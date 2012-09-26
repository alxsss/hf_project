<?php

/**
 * playlist actions.
 *
 * @package    fmpsv
 * @subpackage playlist
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class playlistActions extends sfActions
{
  public function executeList(sfWebRequest $request)
  {
    //$this->playlist_list = PlaylistPeer::doSelect(new Criteria());
	if ($this->getUser()->isAuthenticated())
	{
	  $user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');      
      $this->playlist_list = PlaylistPeer::getMyPlaylist($user_id);
	  $this->song_title=$request->getParameter('song_title');
	  $this->song_url=$request->getParameter('song_url');
	  $this->artist=$request->getParameter('artist');
	  
      $this->music_id= ($this->getRequestParameter('music_id'));
	  $this->form = new PlaylistForm();
	  $this->form->setDefaults(array('user_id'=>$user_id)); 
	}
	else
	{
	  return $this->forward('sfGuardAuth','signin');
	}
  }
  
  public function executeAllplaylists(sfWebRequest $request)
  {
     $this->subscriber = sfGuardUserPeer::retrieveByUsername($this->getRequestParameter('username'));
     $this->forward404Unless($this->subscriber);
     //id of a user whose album are retrived
	 $this->username_user_id=$this->subscriber->getId();
	 $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');      
     $this->playlist_pager = PlaylistPeer::getAllPlaylistsPager($this->getRequestParameter('page', 1), $this->username_user_id);		
  }
  
   public function executeAllfavplaylists()
  { 
    $this->subscriber = sfGuardUserPeer::retrieveByUsername($this->getRequestParameter('username'));
    $this->forward404Unless($this->subscriber);
	//id of a user whose album are retrived
	$this->username_user_id=$this->subscriber->getId();
	$this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');  
	$this->playlists_pager = PlaylistFavPeer::getAllFavPlaylistPager($this->getRequestParameter('page', 1), $this->username_user_id);
	
  }   
  public function executeNew(sfWebRequest $request)
  {
    $this->form = new PlaylistForm();
	$this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
	$this->form->setDefaults(array('user_id'=>$this->user_id));
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new PlaylistForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $user=sfGuardUserProfilePeer::getForToken($request->getParameter('token'));
	$c=new Criteria();
	$c->add(PlaylistPeer::ID, $request->getParameter('id'));
	//print_r($user->getPlaylists($c));
	foreach($user->getPlaylists($c) as $user_playlist)
	{
	  $id=$user_playlist->getId();
	}
	$this->forward404Unless( $this->playlist = PlaylistPeer::retrieveByPk($id), sprintf('Object playlist does not exist (%s).', $id));
    $this->form = new PlaylistForm( $this->playlist);
	
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($playlist = PlaylistPeer::retrieveByPk($request->getParameter('id')), sprintf('Object playlist does not exist (%s).', $request->getParameter('id')));
    $this->form = new PlaylistForm($playlist);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($playlist = PlaylistPeer::retrieveByPk($request->getParameter('id')), sprintf('Object playlist does not exist (%s).', $request->getParameter('id')));
    $playlist->delete();
    //$this->redirect($this->getUser()->getReferer($request->getReferer()));	
    $this->redirect('playlist/list');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $playlist = $form->save();

      $this->redirect('playlist/edit?id='.$playlist->getId());
    }
  }
   public function executeAddplaylist($request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new PlaylistForm();
    $this->song_title=$request->getParameter('song_title');
	$this->song_url=$request->getParameter('song_url');
	$this->artist=$request->getParameter('artist');
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
