<?php

class sfSocialGroupPeer extends BasesfSocialGroupPeer
{

  /**
   * get groups
   * @param  integer       $page  current page
   * @param  integer       $n     max per page
   * @return sfPropelPager
   */
  public static function getGroups($page = 1, $n = 10)
  {
    $c = new Criteria();
    $pager = new sfPropelPager('sfSocialGroup', $n);
    $pager->setCriteria($c);
    $pager->setPeerMethod('doSelectJoinsfGuardUser');
    $pager->setPage($page);
    $pager->init();
    
    return $pager;
  }
  public static function getStatusPager($page, $group_id)
 {
   $pager = new sfPropelPager('GroupStatus', sfConfig::get('app_pager_homepage_max'));
   $c=new Criteria();
   $c->add(GroupStatusPeer::GROUP_ID, $group_id);
   $c->addDescendingOrderByColumn(GroupStatusPeer::CREATED_AT);
   $pager->setCriteria($c);
   $pager->setPage($page);
   $pager->setPeerMethod('doSelect');
   $pager->init(); 
   return $pager;
 }  

}
