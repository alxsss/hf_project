<?php

class GameUser extends BaseGameUser
{
  public function save(PropelPDO  $con = null)
  {
    $ret = parent::save($con);
    // update score of the corresponding game
    $game = $this->getGame();
    $score = $game->getScore();
    $game->setScore($score + 1);
    $game->save($con);
    return $ret;
 }
}
