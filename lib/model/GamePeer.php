<?php

class GamePeer extends BaseGamePeer
{
   public static function getAllUserGamesPager($page, $user_id)
   {
     $pager = new sfPropelPager('Game', sfConfig::get('app_pager_friends_max'));
     $c_game_user = new Criteria();
     $c_game_user->add(GameUserPeer::USER_ID, $user_id);
     $game_users=GameUserPeer::doSelect($c_game_user);
     $game_ids=array();
     foreach($game_users as $game_user)
     { 
        $game_ids[]=$game_user->getGameId();
     }
     $c = new Criteria();
     $c->add(GamePeer::ID, $game_ids, Criteria::IN);
     $c->addDescendingOrderByColumn(self::CREATED_AT);
     $pager->setCriteria($c);
     $pager->setPage($page);
     $pager->setPeerMethod('doSelect');
     $pager->init();
     return $pager;
   }
  public static function getPopularGames()
  {
    $c = new Criteria();
    $c->setLimit(6);
    $c->addDescendingOrderByColumn(self::SCORE);
    $games=GamePeer::doSelect($c);
    return $games;
  }

}
