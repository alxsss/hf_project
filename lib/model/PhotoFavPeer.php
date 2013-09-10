<?php

class PhotoFavPeer extends BasePhotoFavPeer
{
  public static function getAllFavPhotoPager($page, $user_id)
 {
   $pager = new sfPropelPager('Photo', sfConfig::get('app_pager_homepage_max'));  
   $c = new Criteria();
   $c->addJoin(PhotoPeer::ID, PhotoFavPeer::PHOTO_ID);
   $c->add(PhotoFavPeer::USER_ID, $user_id);
   $c->addDescendingOrderByColumn(self::CREATED_AT);
   $pager->setCriteria($c);
   $pager->setPage($page);
   $pager->setPeerMethod('doSelect');
   $pager->init(); 
   return $pager;
 }

}
