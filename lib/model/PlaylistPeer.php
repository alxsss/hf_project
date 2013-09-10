<?php

/**
 * Subclass for performing query and update operations on the 'playlist' table.
 *
 * 
 *
 * @package lib.model
 */ 
class PlaylistPeer extends BasePlaylistPeer
{
  public static function getMyPlaylist($user_id)
  {
    $criteria=new Criteria();
	$criteria->add(PlaylistPeer::USER_ID, $user_id);
	$criteria->addDescendingOrderByColumn(PlaylistPeer::CREATED_AT);
    return PlaylistPeer::doSelect($criteria);
  }
  
    public static function getAllPlaylistsPager($page, $user_id)
 {
   $pager = new sfPropelPager('Playlist', sfConfig::get('app_pager_homepage_max'));  
   $c = new Criteria();
   $c->add(PlaylistPeer::USER_ID, $user_id);
   $pager->setCriteria($c);
   $pager->setPage($page);
   $pager->setPeerMethod('doSelect');
   $pager->init(); 
   return $pager;
 }
}
