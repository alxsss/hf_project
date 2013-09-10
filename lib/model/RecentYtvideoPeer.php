<?php

class RecentYtvideoPeer extends BaseRecentYtvideoPeer
{
  public static function getRecentYtvideoPager($page)
  {
    $pager = new sfPropelPager('RecentYtvideo', sfConfig::get('app_pager_video_max'));
    $c = new Criteria();
    $c->addDescendingOrderByColumn(RecentYtvideoPeer::CREATED_AT);
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->setPeerMethod('doSelect');
    $pager->init();
    return $pager;
  }
}
