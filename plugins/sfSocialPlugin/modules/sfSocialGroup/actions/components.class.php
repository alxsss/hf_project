<?php
class sfSocialgroupComponents extends sfComponents
{ 
  public function executeGlinks(sfWebRequest $request)
  {
    $this->group = sfSocialGroupPeer::retrieveByPK($request->getParameter('id'));
    //$this->forward404Unless($this->group, 'group not found');
    //$this->user = $this->getUser()->getGuardUser();
	$this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
  }  
}