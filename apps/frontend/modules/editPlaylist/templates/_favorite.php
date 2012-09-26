<?php use_helper('User') ?>
<div id="<?php echo 'fav_'.$playlist->getId()?>">
  <?php echo link_to_user_favorite_playlist($sf_user, $playlist)?>  
</div>