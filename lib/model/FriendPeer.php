<?php

class FriendPeer extends BaseFriendPeer
{
 public static function getAllFriendsPager($page, $user_id)
 {
   $pager = new sfPropelPager('Friend', sfConfig::get('app_pager_friends_max'));
   $c=new Criteria();
   $cfriend1 = $c->getNewCriterion(FriendPeer::USER_ID,  $user_id);
   $cfriend2 = $c->getNewCriterion(FriendPeer::FRIEND_ID, $user_id);
   $cfriend1->addOr($cfriend2);
   $c->add($cfriend1);
   $c->add(FriendPeer::APPROVED,1);
   $c->addDescendingOrderByColumn(FriendPeer::CREATED_AT);
   $pager->setCriteria($c);
   $pager->setPage($page);
   $pager->setPeerMethod('doSelect');
   $pager->init(); 
   return $pager;
 }  
}
