<?php

class VideolistYtvideoPeer extends BaseVideolistYtvideoPeer
{
  public static function retrieveByVideolistId( $videolist_id, $con = null)
   {
		if ($con === null)
		{
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(VideolistYtvideoPeer::VIDEOLIST_ID, $videolist_id);
		$v = VideolistYtvideoPeer::doSelect($criteria, $con);
		return !empty($v) ? $v : null;
  }

 public static function getLastViewedVideosPager($page)
 {
   $pager = new sfPropelPager('VideolistYtvideo', sfConfig::get('app_pager_video_max'));
   $c = new Criteria();
   $c->addGroupByColumn(VideolistYtvideoPeer::YTVIDEO_ID); 
   $c->addDescendingOrderByColumn(VideolistYtvideoPeer::CREATED_AT);
   $pager->setCriteria($c);
   $pager->setPage($page);
   $pager->setPeerMethod('doSelect');
   $pager->init();
   return $pager;
 }

}
