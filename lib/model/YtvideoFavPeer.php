<?php

class YtvideoFavPeer extends BaseYtvideoFavPeer
{
   public static function retrieveByVideoId( $video_id, $user_id)
  {
        $criteria = new Criteria();
        $criteria->add(self::VIDEO_ID, $video_id);
        $criteria->add(self::USER_ID, $user_id);
        $v = self::doSelect($criteria);
        return !empty($v) ? $v : null;
  }
  public static function  removeFavVideo($user_id, $video_id)
  {
    $criteria = new Criteria();
        $criteria->add(self::VIDEO_ID, $video_id);
        $criteria->add(self::USER_ID, $user_id);;
    self::doDelete($criteria);
  }

  public static function getAllFavYtvideosPager($page, $user_id)
 {
   $pager = new sfPropelPager('YtvideoFav', sfConfig::get('app_pager_homepage_max'));
   $c = new Criteria();
   $c->add(self::USER_ID, $user_id);
   $c->addDescendingOrderByColumn(self::CREATED_AT);
   $pager->setCriteria($c);
   $pager->setPage($page);
   $pager->setPeerMethod('doSelect');
   $pager->init();
   return $pager;
 }

}
