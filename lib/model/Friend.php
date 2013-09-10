<?php
class Friend extends BaseFriend
{
  //retrives user details by accepting friend_id
  public function getFriend($friend_id, $con=null)
	{
		if ($friend_id !== null) {
			$friend = sfGuardUserPeer::retrieveByPK($friend_id, $con);			
		}
		return $friend;
	}

}
