<?php 
 
class sidebarComponents extends sfComponents
{
  public function executePhotos()
  {
    $this->photos = PhotoPeer::retrieveByPk($this->getRequestParameter('id'));
	$this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
  }
   public function executeVideos()
  {
    $this->videos = VideoPeer::retrieveByPk($this->getRequestParameter('id'));
  }
  public function executeDefault()
  {
  }
}