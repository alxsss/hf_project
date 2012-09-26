<?php
class gamesComponents extends sfComponents
{ 
  public function executeGamecategorylinks()
  {
    $this->id=$this->getRequestParameter('id');
    $this->game_cats = GameCategoryPeer::doSelect(new Criteria());
  }  
}
