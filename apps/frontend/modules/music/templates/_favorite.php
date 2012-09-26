<?php use_helper('User') ?>
<div id="<?php echo 'fav_'.$video_id?>">
  <?php echo link_to_user_favorite_ytvideo($sf_user, $video_id)?>  
</div>