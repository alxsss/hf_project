<?php

/**
 * sfSocialGroup
 *
 * @package    sfSocialPlugin
 * @subpackage sfSocialGroup
 * @author     Massimiliano Arione <garakkio@gmail.com>
 */

class sfSocialGroup extends BasesfSocialGroup
{

  /**
   * magic method
   * @return string
   */
  public function __toString()
  {
    return $this->getTitle();
  }

  /**
   * check if an user is admin of group
   * @param  sfGuardUser $user
   * @return boolean
   */
  public function isAdmin($user_id)
  {
    return $this->getUserAdmin()==$user_id;
  }

  /**
   * check if an user is member of group
   * @param  sfGuardUser $user
   * @return boolean
   */
  public function isMember($user_id)
  {
    $c = new Criteria;
    $c->add(sfSocialGroupUserPeer::GROUP_ID, $this->getId());
    $c->add(sfSocialGroupUserPeer::USER_ID, $user_id);
    $member=sfSocialGroupUserPeer::doSelectOne($c);
	if($member)
      return true;
	else
	  return false;
  }

  /**
   * check if an user is invited to group
   * @param  sfGuardUser $user
   * @return boolean
   */
  public function isInvited($user_id)
  {
    $c = new Criteria;
    $c->add(sfSocialGroupInvitePeer::GROUP_ID, $this->getId());
    $c->add(sfSocialGroupInvitePeer::USER_ID, $user_id);
    //$c->add(sfSocialGroupInvitePeer::REPLIED, 0);
    $invited=sfSocialGroupInvitePeer::doSelectOne($c);
	if($invited)
      return true;
	else
	  return false;
  }

  /**
   * join an user to group
   * @param  sfGuardUser         $user
   * @param  sfSocialGroupInvite $invite if not null, set invite as accepted
   * @return boolean
   */
  public function join($user_id, sfSocialGroupInvite $invite = null)
  {
    try
    {
      $groupUser = new sfSocialGroupUser;
      $groupUser->setUserId($user_id);
      $groupUser->setsfSocialGroup($this);
      if (!empty($invite))
      {
        $invite->setReplied(true);
        $invite->save();
      }
      return $groupUser->save() == 1;
    }
    catch (PropelException $e)
    {
      return false;
    }
  }

  /**
   * get invite of an user to join group
   * @param  sfGuardUser    $user
   * @return sfSocialInvite
   */
  public function getInvite($user_id)
  {
    $c = new Criteria;
    $c->add(sfSocialGroupInvitePeer::GROUP_ID, $this->getId());
    $c->add(sfSocialGroupInvitePeer::USER_ID, $user_id);
    //$c->add(sfSocialGroupInvitePeer::REPLIED, 0);
    $invite=sfSocialGroupInvitePeer::doSelectOne($c);
    if($invite)
      return $invite->getId();
	else
	  return false;
	
  }

  /**
   * get invited users (only ones that did not reply)
   * @return array sfSocialGroupInvite objects
   */
  public function getInvitedUsers()
  {
    $c = new Criteria;
    $c->add(sfSocialGroupInvitePeer::REPLIED, 0);
    return $this->getsfSocialGroupInvitesJoinsfGuardUserRelatedByUserId($c);
  }

}
