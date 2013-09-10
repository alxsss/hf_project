<?php
/**
 * Subclass for performing query and update operations on the 'photo' table.
 *
 * 
 *
 * @package lib.model
 */ 
class PhotoPeer extends BasePhotoPeer
{
 //returns six the most popular photos
 public static function getPopularPhotos()
 {
   $c = new Criteria();
   $c->setLimit(4);
   $c->add(self::APPROVED, 1);
   $c->add(PhotoPeer::POPULAR_PHOTO, 1);
   $c->add(PhotoPeer::VISIBILITY, 0);
   $c->addDescendingOrderByColumn(PhotoPeer::RATING);
   $photos=PhotoPeer::doSelect($c);   
   return $photos;
 }
  public static function getNewPhotos()
 {
   $c = new Criteria();
   $c->setLimit(4);
   $c->add(self::APPROVED, 1);
   $c->add(PhotoPeer::POPULAR_PHOTO, 1);
   $c->add(PhotoPeer::VISIBILITY, 0);
   $c->addDescendingOrderByColumn(PhotoPeer::CREATED_AT);
   $photos=PhotoPeer::doSelect($c);   
   return $photos;
 }
public static function getPopularPhotosPager($page)
{
  $pager = new sfPropelPager('Photo', sfConfig::get('app_pager_popular_photos_max'));  
  $c = new Criteria();
  $c->add(self::APPROVED, 1);
  $c->add(PhotoPeer::POPULAR_PHOTO, 1);
  $c->add(PhotoPeer::VISIBILITY, 0);
  $c->addDescendingOrderByColumn(PhotoPeer::RATING);
  $pager->setCriteria($c);
  $pager->setPage($page);
  //$pager->setPeerMethod('doSelectJoinUser');
  $pager->setPeerMethod('doSelect');
  $pager->init(); 
  return $pager;
}public static function getNewPhotosPager($page)
{
  $pager = new sfPropelPager('Photo', sfConfig::get('app_pager_popular_photos_max'));  
  $c = new Criteria();
  $c->add(self::APPROVED, 1);
  $c->add(PhotoPeer::POPULAR_PHOTO, 1);
  $c->add(PhotoPeer::VISIBILITY, 0);
  $c->addDescendingOrderByColumn(PhotoPeer::CREATED_AT);
  $pager->setCriteria($c);
  $pager->setPage($page);
  //$pager->setPeerMethod('doSelectJoinUser');
  $pager->setPeerMethod('doSelect');
  $pager->init(); 
  return $pager;
}
public static function getShowPhotoPager($user_id)
{
  $c = new Criteria();
  $c->add(self::APPROVED, 1);
  $c->add(PhotoPeer::USER_ID, $user_id);
  $c->add(PhotoPeer::ALBUM_ID, NULL);
  $c->addDescendingOrderByColumn(self::CREATED_AT);
  $photos=PhotoPeer::doSelect($c); 
  return $photos;
}
public static function getShownewPhotoPager()
{
  $c = new Criteria();
  $c->add(self::APPROVED, 1);
  $c->add(PhotoPeer::POPULAR_PHOTO, 1);
  $c->add(PhotoPeer::VISIBILITY, 0);
  $c->addDescendingOrderByColumn(PhotoPeer::CREATED_AT);
  $photos=PhotoPeer::doSelect($c); 
  return $photos;
}
public static function getShowpopularPhotoPager()
{
  $c = new Criteria();
  $c->add(self::APPROVED, 1);
  $c->add(PhotoPeer::POPULAR_PHOTO, 1);
  $c->add(PhotoPeer::VISIBILITY, 0);
  $c->addDescendingOrderByColumn(PhotoPeer::RATING);
  $photos=PhotoPeer::doSelect($c); 
  return $photos;
}
  public static function getAllPhotosPager($page, $user_id)
 {
   $pager = new sfPropelPager('Photo', sfConfig::get('app_pager_friends_max'));  
   $c = new Criteria();
   $c->add(PhotoPeer::USER_ID, $user_id);
   $c->add(PhotoPeer::ALBUM_ID, NULL);
   $c->addDescendingOrderByColumn(self::CREATED_AT);
   $pager->setCriteria($c);
   $pager->setPage($page);
   $pager->setPeerMethod('doSelect');
   $pager->init(); 
   return $pager;
 }
}
