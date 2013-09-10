<?php

class GameCategoryPeer extends BaseGameCategoryPeer
{
 public static function getCategoryGames($page, $cat_id)
 {
   $pager = new sfPropelPager('Game', sfConfig::get('app_pager_games_max'));
   $c=new Criteria();
   $c->add(GamePeer::GAME_CATEGORY_ID,$cat_id);
   $pager->setCriteria($c);
   $pager->setPage($page);
   $pager->setPeerMethod('doSelect');
   $pager->init();
   return $pager;
 }

}
