<?php use_helper('I18N', 'Text')?>
<div id="updates_left_column">
  <?php if($sf_user->isAuthenticated()):?>
    <?php include_component('friends', 'ulinks')?>
  <?php else:?>
    <?php include_partial('home/inhemsinif')?>
  <?php endif;?>
 <?php include_partial('friends/ad200x200')?>
</div>
<div id="right_column_user">
 <div class="cat_games">
  <?php $c_game=new Criteria();$c_game->setLimit(5);?>
  <?php foreach ($game_cats as $game_cat):?>
    <div class="cat-col">
      <div class="cat-section">
        <div class="cat-name"><a href="<?php echo url_for('games/category?id='.$game_cat->getId())?>"><?php echo __($game_cat->getRawValue()->getDisplayName())?></a></div>
        <ul class="list">
          <?php foreach($game_cat->getGames($c_game) as $game):?>
            <li><a href="<?php echo url_for('games/show?id='.$game->getId())?>"><img class="icon" src="<?php echo substr($game->getThumb(), 0, -12).'32x32.jpeg'?>">
               <?php echo truncate_text($game->getName(),20); ?> </a>
           </li>
         <?php endforeach;?>   
      </ul>
     <?php $num_games=$game_cat->getNumGames(); if($num_games>200){$num_games=200;}?>
     <div class="view-more"><a href="<?php echo url_for('games/category?id='.$game_cat->getId())?>"><?php echo __('View %num_games% more',array('%num_games%'=>$num_games-10))?></a> </div>
  </div>
</div>
<?php endforeach;?>
</div>
</div>
<?php include_partial('friends/horizontal_ad')?>
