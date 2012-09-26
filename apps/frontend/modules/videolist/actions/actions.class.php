<?php

/**
 * videolist actions.
 *
 * @package    fmpsv
 * @subpackage videolist
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class videolistActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->videolist_list = VideolistPeer::doSelect(new Criteria());
	if ($this->getUser()->isAuthenticated())
	{
	  $user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');      
      $this->videolist_list = VideolistPeer::getMyVideolist($user_id);
	  $this->video_id=$request->getParameter('video_id');
	  $this->form = new VideolistForm();
	  $this->form->setDefaults(array('user_id'=>$user_id)); 
	}
	else
	{
	  return $this->forward('sfGuardAuth','signin');
	}
  }
   public function executeAddvideolist($request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new VideolistForm();
    //this done because data comes from jquery post ajax request
    $videolist_array=$request->getParameter('album_data');
    $this->videolist=array();
    $this->videolist['name']=$videolist_array[0]['value'];
    $this->videolist['id']=$videolist_array[1]['value'];
    $this->videolist['user_id']=$videolist_array[2]['value'];

    $this->form->bind($this->videolist);
    if ($this->form->isValid())
    {
      $this->form->save();
    }
    $user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');  
    $this->videolist_list = VideolistPeer::getMyVideolist($user_id);	
    //$this->VideolistForm = new VideolistForm();  
  }
  public function executeNew(sfWebRequest $request)
  {
    $this->form = new VideolistForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new VideolistForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($videolist = VideolistPeer::retrieveByPk($request->getParameter('id')), sprintf('Object videolist does not exist (%s).', $request->getParameter('id')));
    $this->form = new VideolistForm($videolist);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($videolist = VideolistPeer::retrieveByPk($request->getParameter('id')), sprintf('Object videolist does not exist (%s).', $request->getParameter('id')));
    $this->form = new VideolistForm($videolist);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($videolist = VideolistPeer::retrieveByPk($request->getParameter('id')), sprintf('Object videolist does not exist (%s).', $request->getParameter('id')));
    $videolist->delete();
     if(!$request->isXmlHttpRequest())
     {
      $this->redirect('videolist/index');
     }
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $videolist = $form->save();

      $this->redirect('@videolist');
    }
  }
}
