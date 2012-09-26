<div class="user_contact">
  <?php foreach($game_cats as $game_cat):?>
    <a href="<?php echo url_for('games/category?id='.$game_cat->getId())?>" class="user_links <?php if($game_cat->getId()==$id){echo 'selected_link';}?>"><?php echo __($game_cat->getRawValue()->getDisplayName())?> </a>
  <?php endforeach;?>
</div>
