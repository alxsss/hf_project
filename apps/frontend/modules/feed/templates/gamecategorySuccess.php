 <?php //print_r($feed->categories->category)?>
 <?php
   foreach($feed->categories->category as $i=>$game_category)
   {
     //print_r($game_category);
     $game_cat=new GameCategory();
     $game_cat->setName($game_category->name);
	 $game_cat->setDisplayName($game_category->display_name);
	 $num_games=$game_category->num_games;
	// print_r($num_games[0]);
     $game_cat->setNumGames(trim($num_games[0]));
	 //echo $num_games.'<br>';
     $game_cat->save();
     //echo (string)$game_category->display_name;
   }
 ?>
