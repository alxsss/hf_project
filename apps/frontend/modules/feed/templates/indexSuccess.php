 <?php //print_r($feed->categories->category)?>
 <?php foreach($feed->categories->category as $i=>$game_category): ?>
   <?php //print_r($game_category)?>
   <?php echo (string)$game_category->display_name?>
   <?php //$game_cat=new GameCategory();?>
   <?php //$game_cat->setName($game_category->display_name);?>
   <?php //$game_cat->setNumGames($game_category->num_games)?>
   <?php //$game_cat->save();?>
   <?php //echo (string)$game_category->display_name?>
 <?php endforeach; ?>
