<?php
class sfSocialeventComponents extends sfComponents
{ 
  public function executeElinks(sfWebRequest $request)
  {
    $this->event= sfSocialEventPeer::retrieveByPK($request->getParameter('id'));
   //this method is not defined in component classes$this->forward404Unless($this->event, 'event not found');
    $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
  }  
}
