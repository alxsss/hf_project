<?php

class sfSocialEvent extends BasesfSocialEvent
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
   * get start and end dates in a fancy format
   * @param  string $dateF date format
   * @param  string $timeF time format
   * @return string
   */
  public function getWhen($dateF = 'j M Y', $timeF = 'H:i')
  {
    // event starts and ends in same day
    if ($this->getStart('zY') == $this->getEnd('zY'))
    {
      $string = '%day% from %starttime% to %endtime%';
      $params = array('%day%'=>format_date($this->getStart(),'p'), '%starttime%'=>$this->getStart($timeF), '%endtime%'=>$this->getEnd($timeF));
    }
    else
    {
    // event spans in more days
      $string = 'from %startdaytime% to %enddatetime%';
      $params = array('%startdaytime%'=>format_date($this->getStart(), 'p'), '%enddatetime%'=>format_date($this->getEnd(), 'p') );
    }
    // possibly localize string
    if (sfConfig::get('sf_i18n'))
    {
      $i18n = sfContext::getInstance()->getI18N();
      return $i18n->__($string, $params);
    }
    else
    {
      return __(strtr($string, $params));
    }
  }
  public function isAdmin($user_id)
  {
    return $this->getUserAdmin() == $user_id;
  }
  public function isInvited($user_id)
  {
    $c = new Criteria;
    $c->add(sfSocialEventInvitePeer::EVENT_ID, $this->getId());
    $c->add(sfSocialEventInvitePeer::USER_ID, $user_id);
   //$c->add(sfSocialEventInvitePeer::REPLIED, 0);
    $invited=sfSocialEventInvitePeer::doSelectOne($c);
    if($invited)
      return true;
     else
      return false;
  }
  public function getConfirmedUsers()
  {
    $c = new Criteria;
    $c->add(sfSocialEventUserPeer::CONFIRM, sfSocialEventUserPeer::REPLY_YES);
    return $this->getsfSocialEventUsersJoinsfGuardUser($c);
  }
  public function getMaybeUsers()
  {
    $c = new Criteria;
    $c->add(sfSocialEventUserPeer::CONFIRM, sfSocialEventUserPeer::REPLY_MAYBE);
    return $this->getsfSocialEventUsersJoinsfGuardUser($c);
  }
  public function getNoUsers()
  {
    $c = new Criteria;
    $c->add(sfSocialEventUserPeer::CONFIRM, sfSocialEventUserPeer::REPLY_NO);
    return $this->getsfSocialEventUsersJoinsfGuardUser($c);
  }
  public function getAwaitingReplyUsers()
  {
    $c = new Criteria;
    $c->add(sfSocialEventInvitePeer::REPLIED, 0);
    return $this->getsfSocialEventInvitesJoinsfGuardUserRelatedByUserId($c);
  }

}
