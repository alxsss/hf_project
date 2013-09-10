<?php

/**
 * Subclass for performing query and update operations on the 'album' table.
 *
 * 
 *
 * @package lib.model
 */ 
class AlbumPeer extends BaseAlbumPeer
{
   static public function getAlbumCriteria()
   {
     $user_id=sfContext::getInstance()->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
	 $criteria = new Criteria();
     $criteria->add(AlbumPeer::USER_ID, $user_id);
	 $criteria->addDescendingOrderByColumn(AlbumPeer::ID);
	 return $criteria;
   }
   
   public static function getAllAlbumsPager($page, $user_id)
 {
   $pager = new sfPropelPager('Album', sfConfig::get('app_pager_homepage_max'));  
   $c = new Criteria();
   $c->add(AlbumPeer::USER_ID, $user_id);
   $c->addDescendingOrderByColumn(self::CREATED_AT);
   $pager->setCriteria($c);
   $pager->setPage($page);
   $pager->setPeerMethod('doSelect');
   $pager->init(); 
   return $pager;
 }
}
