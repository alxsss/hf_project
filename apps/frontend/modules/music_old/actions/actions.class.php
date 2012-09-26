<?php

/**
 * music actions.
 *
 * @package    fmpsv
 * @subpackage music
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class musicActions extends sfActions
{
   
  public function executeList(sfWebRequest $request)
  {
    $this->music_list = MusicPeer::doSelect(new Criteria());
  }
  public function executeIndex(sfWebRequest $request)
  {
    /*$c=new Criteria();
	$c->addDescendingOrderByColumn(PlaylistPeer::CREATED_AT);
	$this->playlist=PlaylistPeer::doSelectOne($c);*/
  }
  public function executeShow()
  {
     $this->song = MusicPeer::retrieveByPk($this->getRequestParameter('id'));
     $this->forward404Unless($this->song);
	 $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
  }
  public function executeSearch(sfWebRequest $request)
  {
    //$this->query = $request->getParameter('query');
    //$this->getUser()->setReferer( $this->query, 'query');
	
	//echo $this->getUser()->getReferer($request->getReferer());
	//$this->query=$this->getUser()->getReferer('query');
	//echo $this->query;
   if (1)
   {   
     if (!$this->query = $request->getParameter('query'))
     {
	   //return $this->redirect('music/index');	  
     } 
	 $this->query=urlencode(trim($this->query));
   
     $this->page = ($request->getParameter('page')) ? $request->getParameter('page'):0;
	 $start=10*$this->page;
     $uri = 'http://localhost:8080/fmpsv/opensearch?query='.$this->query.'&hitsPerSite=0&lang=en&hitsPerPage=10&start='.$start.'&clustering=';
     //$uri = 'http://localhost:8080/nutch-1.0/opensearch?query='.$this->query.'&hitsPerSite=0&lang=en&hitsPerPage=10&start='.$start.'&clustering=';
     $browser = new sfWebBrowser(array(
      'user_agent' => 'sfFeedReader/0.9',
      'timeout'    => 5 ));
     $feedString = $browser->get($uri)->getResponseText();
	
	 $p = xml_parser_create();
     xml_parse_into_struct($p, $feedString, $vals, $index);
     xml_parser_free($p);
	 $nbResults=10;
     foreach($vals as $val)
     {
       if($val['tag']=='OPENSEARCH:TOTALRESULTS')
       {
         $nbResults=$val['value'];
         break;
       }
     }
	 $nbResults=(int)($nbResults-$nbResults/10);
     $this->feed_pager = new sfFeedPager('Feed', sfConfig::get('app_pager_music_max'), $nbResults);  
     $this->feed_pager->setPage($this->page);
     $this->feed_pager->init(); 
	
	 $feed = new sfRssFeed();
	 //$feed->setUrl($uri);
     $feed->fromXml($feedString);
	 $this->feed = $feed;
	 
	 $this->local_songs = MusicPeer::getForLuceneQuery($this->query);
	
  }
  else
  {
    return $this->redirect('music/index');
  } 
	
	//$this->feed = sfFeedPeer::createFromWeb($uri);
}
public function executeSearchajax(sfWebRequest $request)
  {
    //$this->query = $request->getParameter('query');
    //$this->getUser()->setReferer( $this->query, 'query');
	
	//echo $this->getUser()->getReferer($request->getReferer());
	//$this->query=$this->getUser()->getReferer('query');
	//echo $this->query;
   if (1)
   {   
     if (!$this->query = $request->getParameter('query'))
     {
	   //return $this->redirect('music/index');	  
     } 
	 $this->query=urlencode(trim($this->query));
     
     $this->page = ($request->getParameter('page')) ? $request->getParameter('page'):0;
	 $start=10*$this->page;
     $uri = 'http://localhost:8080/fmpsv/opensearch?query='.$this->query.'&hitsPerSite=0&lang=en&hitsPerPage=10&start='.$start.'&clustering=';
     //$uri = 'http://localhost:8080/nutch-1.0/opensearch?query='.$this->query.'&hitsPerSite=0&lang=en&hitsPerPage=10&start='.$start.'&clustering=';
     $browser = new sfWebBrowser(array(
      'user_agent' => 'sfFeedReader/0.9',
      'timeout'    => 5 ));
     $feedString = $browser->get($uri)->getResponseText();
	
	 $p = xml_parser_create();
     xml_parse_into_struct($p, $feedString, $vals, $index);
     xml_parser_free($p);
	 $nbResults=10;
     foreach($vals as $val)
     {
       if($val['tag']=='OPENSEARCH:TOTALRESULTS')
       {
         $nbResults=$val['value'];
         break;
       }
     }
	 $nbResults=(int)($nbResults-$nbResults/10);
     $this->feed_pager = new sfFeedPager('Feed', sfConfig::get('app_pager_music_max'), $nbResults);  
     $this->feed_pager->setPage($this->page);
     $this->feed_pager->init(); 
	
	 $feed = new sfRssFeed();
	 //$feed->setUrl($uri);
     $feed->fromXml($feedString);
	 $this->feed = $feed;
	 $this->local_songs = MusicPeer::getForLuceneQuery($this->query);
  }
  else
  {
    return $this->redirect('music/index');
  } 
	
	//$this->feed = sfFeedPeer::createFromWeb($uri);
} 
  public function executeRefresh($request)
  {
    $this->song_url=$request->getParameter('song_url');
	$this->song_title=$request->getParameter('song_title');
	$this->button_number=$request->getParameter('button_number');
	$this->play=$request->getParameter('play');
  }
  public function executeLoadplaylist(sfWebRequest $request)
  {
    $this->song_url=$request->getParameter('song_url');
	$this->song_title=$request->getParameter('song_title');
  } 
  public function executeNew(sfWebRequest $request)
  {
    $this->form = new MusicForm();
  }
 public function executeNomusic(sfWebRequest $request)
  {
    
  }
  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new MusicForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    if ($this->getUser()->isAuthenticated())
    {
	  $this->forward404Unless($music = MusicPeer::retrieveByPk($request->getParameter('id')), sprintf('Object music does not exist (%s).', $request->getParameter('id')));
      $this->form = new MusicForm($music);
	  $this->playlistForm = new PlaylistForm();
	  $user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
	  $this->playlistForm->setDefaults(array('user_id'=>$user_id)); 
	  $this->playlist_list = PlaylistPeer::getMyPlaylist($user_id);
	 }
	 else	
	 {
    	return $this->forward('sfGuardAuth','signin');
     }
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($music = MusicPeer::retrieveByPk($request->getParameter('id')), sprintf('Object music does not exist (%s).', $request->getParameter('id')));
    $this->form = new MusicForm($music);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($music = MusicPeer::retrieveByPk($request->getParameter('id')), sprintf('Object music does not exist (%s).', $request->getParameter('id')));
    $music->delete();
    
	//delete file from hard disk
	$this->uploadDirName='/uploads/assets';
    $this->uploadDir     = sfConfig::get('sf_web_dir').$this->uploadDirName;
	$musicFile = $this->uploadDir.'/music/'. $music->getUrl();
	unlink($musicFile);	
    $this->redirect('music/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $music = $form->save();
      $playlistMusic=new PlaylistMusic();
	  $playlistMusic->setPlaylistId($request->getParameter('playlist_list'));
	  $playlistMusic->setMusicId($request->getParameter('id'));
	  $playlistMusic->save();
	  
	  
      $this->redirect('music/edit?id='.$music->getId());
    }
  }
  
   public function executeAddplaylist($request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new PlaylistForm();
    
    $this->form->bind($request->getParameter('playlist'));
    if ($this->form->isValid())
    {
      $this->form->save();
    }
	$user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');  
	$this->playlist_list = PlaylistPeer::getMyPlaylist($user_id);	
	$this->form = new PlaylistForm();  
  }
}
