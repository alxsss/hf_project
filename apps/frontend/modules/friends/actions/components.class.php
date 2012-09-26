<?php
class friendsComponents extends sfComponents
{ 
  public function executeUlinks()
  {
    if ($this->getUser()->isAuthenticated())
    {
	  $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');	
      $this->subscriber = sfGuardUserPeer::retrieveByPk($this->user_id);
      $this->inbox_num_msgs = $this->subscriber->countInboxMessages();
	  $this->num_requests = $this->subscriber->count_num_friend_requests()+$this->subscriber->count_group_invites()+$this->subscriber->count_event_invites();
	  $this->num_guests = $this->subscriber->count_num_guests();
	  $this->num_rates = $this->subscriber->count_num_rates();    
	}
  }  
}
