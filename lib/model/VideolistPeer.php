<?php

class VideolistPeer extends BaseVideolistPeer
{
  public static function getMyVideolist($user_id)
  {
    $criteria=new Criteria();
	$criteria->add(VideolistPeer::USER_ID, $user_id);
	$criteria->addDescendingOrderByColumn(VideolistPeer::CREATED_AT);
    return VideolistPeer::doSelect($criteria);
  }
  
 public static function getAllVideolistsPager($page, $user_id)
 {
   $pager = new sfPropelPager('Videolist', sfConfig::get('app_pager_homepage_max'));  
   $c = new Criteria();
   $c->add(VideolistPeer::USER_ID, $user_id);
   $pager->setCriteria($c);
   $pager->setPage($page);
   $pager->setPeerMethod('doSelect');
   $pager->init(); 
   return $pager;
 }
}
