<?php
  $c=new Criteria();
  $game_cats=GameCategoryPeer::doSelect($c);
  foreach($game_cats as $game_cat)
  {
    $url='http://www.heyzap.com/publisher_api/v2/games_by_category?category='.strtolower($game_cat->getName()).'&embed_key=a0a44aa5ff&secret_key=9ca4d5a76c&format=xml';
	$xml = simpleXML_load_file($url);
	//print_r($xml);
	//exit;
	echo strtolower($game_cat->getName());
    foreach($xml->games->game as $xml_game)
    {
      $game=new Game();
      $game->setGameCategoryId($game_cat->getId());
      $game->setName($xml_game->display_name);
      $game->setEmbedCode($xml_game->embed_code);
      $game->setDescription($xml_game->description);
      $game->setThumb($xml_game->thumb_100x100);
      $game->setCreatedAt($xml_game->last_updated);
      $game->setCreativeScreenshot($xml_game->creative_screenshot);
	  $game->save();
    }
  }
?>    
