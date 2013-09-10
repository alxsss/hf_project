<?php
class GuestPeer extends BaseGuestPeer
{
  public static function getAllGuestsPager($page, $user_id)
  {
   $pager = new sfPropelPager('Guest', sfConfig::get('app_pager_homepage_max'));
   $c=new Criteria();
   $c->add(GuestPeer::USER_ID, $user_id);
   $c->addDescendingOrderByColumn(GuestPeer::CREATED_AT);
   $pager->setCriteria($c);
   $pager->setPage($page);
   $pager->setPeerMethod('doSelect');
   $pager->init(); 
   return $pager;
  }  
}