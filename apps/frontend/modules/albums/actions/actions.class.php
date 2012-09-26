<?php

/**
 * albums actions.
 *
 * @package    fmpsv
 * @subpackage albums
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 8507 2008-04-17 17:32:20Z fabien $
 */
class albumsActions extends sfActions
{
  public function executeCreate()
  {
    $this->form = new AlbumForm();

    $this->setTemplate('edit');
  }
  public function preExecute()
  {
    if ($this->getUser()->isAuthenticated())
    {
	  $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');	
      $this->subscriber = sfGuardUserPeer::retrieveByPk($this->user_id);
      $this->forward404Unless($this->subscriber);	  
	}
  }
  public function executeEdit($request)
  {
    if ($this->getUser()->isAuthenticated())
    {
	  $this->form = new AlbumForm(AlbumPeer::retrieveByPk($request->getParameter('id')));
	}
	else
	{
	  $this->redirect('@homepage');
	}
  }

  public function executeUpdate($request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->form = new AlbumForm(AlbumPeer::retrieveByPk($request->getParameter('id')));
    $this->form->bind($request->getParameter('album'));
    if ($this->form->isValid())
    {
      $album = $this->form->save();
      $this->redirect('albums/show?id='.$album->getId());
    }
	else
	{
	  $this->setTemplate('edit');
	}
  }

  public function executeDelete($request)
  {
    $this->forward404Unless($album = AlbumPeer::retrieveByPk($request->getParameter('id')));
    $username=$album->getsfGuardUser();
	foreach($album->getPhotos() as $photo)
	{
	  $photo->delete();
	}
    $album->delete();
    
    $this->redirect('user/'.$username);
  }
  
   public function executeShow()
  {
    $this->album = AlbumPeer::retrieveByPk($this->getRequestParameter('id'));
	$this->forward404Unless($this->album);
	$this->firstPhoto=$this->album->getLastPhoto();
    $this->album_user_id=$this->album->getUserId();
	$this->album_owner = sfGuardUserPeer::retrieveByPk($this->album_user_id);
    $this->forward404Unless($this->album_owner); 
	//define this here if user is not signed in in order not to ger undefined user_id notice
    $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');   	
  }
  
   public function executeList()
   { 
     $this->album_owner = sfGuardUserPeer::retrieveByUsername($this->getRequestParameter('username'));
     $this->forward404Unless($this->album_owner);
	 //id of a user whose album are retrived
	 $user_id=$this->album_owner->getId();
	 $this->albums=AlbumPeer::getAllAlbumsPager($this->getRequestParameter('page', 1), $user_id);
	 
	 //id of a user who signed in
	 $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');	
   }

}
