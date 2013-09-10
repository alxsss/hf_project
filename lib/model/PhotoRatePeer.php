<?php
class PhotoRatePeer extends BasePhotoRatePeer
{
  public static function getPhotoRatingPager($page, $user_id)
 {
   $pager = new sfPropelPager('PhotoRate', sfConfig::get('app_pager_homepage_max'));  
   $c=new Criteria();
   $c->add(PhotoPeer::USER_ID, $user_id);  
   $c->add(PhotoRatePeer::DELETED,0);
   $c->addDescendingOrderByColumn(PhotoRatePeer::CREATED_AT);
   $pager->setCriteria($c);
   $pager->setPage($page);  
   $pager->setPeerMethod('doSelectJoinPhoto');
   $pager->setPeerCountMethod('doCountJoinPhoto');
   $pager->init(); 
   return $pager;
 }
}
