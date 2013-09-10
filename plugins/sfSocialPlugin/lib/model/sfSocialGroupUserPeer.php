<?php

class sfSocialGroupUserPeer extends BasesfSocialGroupUserPeer
{
  public static function getAllGroupMembersPager($group_id, $page)
  {
    $pager = new sfPropelPager('sfSocialGroupUser', sfConfig::get('app_pager_friends_max'));
    $c = new Criteria();
    $c->add(self::GROUP_ID, $group_id);
    $c->addDescendingOrderByColumn(self::CREATED_AT);
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->setPeerMethod('doSelectJoinsfGuardUser');
    $pager->init();
    return $pager;
   }

}
