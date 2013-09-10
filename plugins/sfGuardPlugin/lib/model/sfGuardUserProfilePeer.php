<?php

class sfGuardUserProfilePeer extends BasesfGuardUserProfilePeer
{
  static public function getForToken($parameters)
  {
    $user = sfGuardUserPeer::getByToken($parameters);
    if (!$user)
    {
      throw new sfError404Exception(sprintf('User with token "%s" does not exist .', $parameters));
    }
 
    //return $user->getProfile()->getId();
	return $user;
  }
  
  
}
