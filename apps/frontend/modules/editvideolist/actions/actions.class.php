<?php

/**
 * editvideolist actions.
 *
 * @package    fmpsv
 * @subpackage editvideolist
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class editvideolistActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->videolist_ytvideo_list = VideolistYtvideoPeer::doSelect(new Criteria());
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new VideolistYtvideoForm();
  }
  public function executeShow(sfWebRequest $request)
  {
    $this->videolist_id=$request->getParameter('videolist_id');
	$this->videolist_ytvideo = VideolistYtvideoPeer::retrieveByVideolistId($this->videolist_id);
	$this->videolist=VideolistPeer::retrieveByPk($this->videolist_id);
    $this->forward404Unless($this->videolist);
	$this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
  }
  public function executePlayvideolist(sfWebRequest $request)
  {
    $this->video_id=$request->getParameter('video_id');
    $this->videolist_id=$request->getParameter('videolist_id');
    $this->videolist_ytvideo = VideolistYtvideoPeer::retrieveByVideolistId($this->videolist_id);
   // $yt = new Zend_Gdata_YouTube();
    //$entry = $yt->getVideoEntry($videoId);
    //$this->thumbnailUrl = $entry->mediaGroup->thumbnail[0]->url;
    //$this->videoTitle = $entry->mediaGroup->title;
    //$this->videoUrl =$this->findFlashUrl($entry);

    //record played video in recent_ytvideo table once
    if($videoId)
    {
      $c=new Criteria();
      $c->add(RecentYtvideoPeer::YTVIDEO_ID, $videoId);
      $ytvideo=RecentYtvideoPeer::doSelectOne($c);
      if(empty($ytvideo))
      {
        $ytvideo=new RecentYtvideo();
        $ytvideo->setYtvideoId($videoId);
      }
      else
      {
        $ytvideo->setCreatedAt(time());
      }
      $ytvideo->save();
    }
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new VideolistYtvideoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($videolist_ytvideo = VideolistYtvideoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object videolist_ytvideo does not exist (%s).', $request->getParameter('id')));
    $this->form = new VideolistYtvideoForm($videolist_ytvideo);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    
	if ((!$this->getRequestParameter('videolist_id'))&&(!$this->getRequestParameter('video_id')))
    {
       return $this->redirect('videolist/list');	  
    }
	//check if this record already exists
	$c=new Criteria();
	$c->add(VideolistYtvideoPeer::VIDEOLIST_ID, $this->getRequestParameter('videolist_id'));
	$c->add(VideolistYtvideoPeer::YTVIDEO_ID, $this->getRequestParameter('video_id'));
	$videolist_ytvideo = VideolistYtvideoPeer::doSelectOne($c);
	if(!$videolist_ytvideo)
	{ 
	  $videolist_ytvideo = new VideolistYtvideo();
      $videolist_ytvideo->setVideolistId($this->getRequestParameter('videolist_id'));
	  $videolist_ytvideo->setYtvideoId($this->getRequestParameter('video_id'));
      $videolist_ytvideo->save();
	}
    return $this->redirect('editvideolist/show?videolist_id='.$videolist_ytvideo->getVideolistId());
	/*$this->forward404Unless($videolist_ytvideo = VideolistYtvideoPeer::retrieveByPk($request->getParameter('videolist_id')), sprintf('Object videolist_ytvideo does not exist (%s).', $request->getParameter('id')));
    $this->form = new VideolistYtvideoForm($videolist_ytvideo);
    $this->processForm($request, $this->form);
    $this->setTemplate('edit');*/
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($videolist_ytvideo = VideolistYtvideoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object videolist_ytvideo does not exist (%s).', $request->getParameter('id')));
    $videolist_ytvideo->delete();
    //return $this->redirect('editvideolist/show?videolist_id='.$this->getRequestParameter('videolist_id'));
    //$this->redirect('editvideolist/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $videolist_ytvideo = $form->save();

      $this->redirect('editvideolist/edit?id='.$videolist_ytvideo->getId());
    }
  }
}
