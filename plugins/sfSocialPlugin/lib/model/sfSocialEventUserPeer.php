<?php

class sfSocialEventUserPeer extends BasesfSocialEventUserPeer
{
  // possible replies to invite

  const REPLY_MAYBE = 1;
  const REPLY_YES   = 2;
  const REPLY_NO    = 3;

  static public $confirmChoices = array(self::REPLY_MAYBE => 'maybe',
                                        self::REPLY_YES   => 'yes',
                                        self::REPLY_NO    => 'no');

 public static function getConfirmedUsersPager($event_id, $page)
  {
    $pager = new sfPropelPager('sfSocialEventUser', sfConfig::get('app_pager_homepage_max'));
    $c = new Criteria;
    $c->add(sfSocialEventUserPeer::EVENT_ID, $event_id);
    $c->add(sfSocialEventUserPeer::CONFIRM, sfSocialEventUserPeer::REPLY_YES);
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->setPeerMethod('doSelectJoinsfGuardUser');
    $pager->init();
    return $pager;
    //return $this->getsfSocialEventUsersJoinsfGuardUser($c);
  }

  /**
   * get users that replied "maybe"
   * @return array
   */
  public static function getMaybeUsersPager($event_id, $page)
  {
    $pager = new sfPropelPager('sfSocialEventUser', sfConfig::get('app_pager_homepage_max'));
    $c = new Criteria;
    $c->add(sfSocialEventUserPeer::EVENT_ID, $event_id);
    $c->add(sfSocialEventUserPeer::CONFIRM, sfSocialEventUserPeer::REPLY_MAYBE);
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->setPeerMethod('doSelectJoinsfGuardUser');
    $pager->init();
    return $pager;
  }

  /**
   * get users that replied "no"
   * @return array
   */
  public static function getNoUsersPager($event_id, $page)
  {
    $pager = new sfPropelPager('sfSocialEventUser', sfConfig::get('app_pager_homepage_max'));
    $c = new Criteria;
    $c->add(sfSocialEventUserPeer::EVENT_ID, $event_id);
    $c->add(sfSocialEventUserPeer::CONFIRM, sfSocialEventUserPeer::REPLY_NO);
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->setPeerMethod('doSelectJoinsfGuardUser');
    $pager->init();
    return $pager;
  }
 public static function getAwaitingReplyUsersPager($event_id, $page)
  {
    $pager = new sfPropelPager('sfSocialEventInvite', sfConfig::get('app_pager_homepage_max'));
    $c = new Criteria;
    $c->add(sfSocialEventInvitePeer::EVENT_ID, $event_id);
    $c->add(sfSocialEventInvitePeer::REPLIED, 0);
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->setPeerMethod('doSelect');
    $pager->init();
    return $pager;
    //return $this->getsfSocialEventInvitesJoinsfGuardUserRelatedByUserId($c);
  }

}
