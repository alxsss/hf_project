<?php use_helper('I18N', 'Global') ?>
<div id="updates_left_column">
<div class="user_contact">
  	<!--in case if a user is not signed in and album is visible $user_id is not defined-->
    <div class="user_links"><?php echo link_to($photo_owner->getUsername().__('\'s profile'), 'user/'.$photo_owner->getUsername()) ?></div>	
   	<div class="user_links"><?php echo link_to(__('All photos by %author%', array('%author%'=>$photo_owner->getUsername())),'@all_photos?username='.$photo_owner->getUsername())?></div>
   	<div class="user_links"><?php echo link_to( __('All albums by %author%', array('%author%'=>$photo_owner->getUsername())), '@all_albums?username='.$photo_owner->getUsername())?></div>
  </div> 
<?php if($sf_user->isAuthenticated()):?> 
 <?php include_component('friends', 'ulinks')?>
<?php else:?>
  <?php include_partial('home/inhemsinif')?>	    
<?php endif;?>
</div>
<div id="right_column_user">
  <div class="all_photos"><?php echo __('All games played by %author%', array('%author%'=>$photo_owner->getUsername()))?></div>
    <div class="friends_to_be_invited">
      <div class="friends_to_be_invited_line"><?php $cnt=0;?>
        <?php foreach ($games->getResults() as $game): ?>
	  <?php $cnt++;?>
          <?php $pic_url=$game->getThumb()?>
          <div class="user_game">
	    <a href="<?php echo url_for('games/show?id='.$game->getId())?>">
              <div class="album_image">
                <?php echo image_tag($pic_url, 'alt=no img class=image_with_border')?>
	      </div>	
	    </a>	
	  </div>	
          <?php if($cnt==5){echo '</div><div class="friends_to_be_invited_line">';$cnt=0;}?>	
       <?php endforeach; ?>
     </div>
     <?php if($games->haveToPaginate()):?>
       <div class="pagination">
         <div id="photos_pager">
           <?php echo pager_navigation($games, 'games/allgames?username='.$photo_owner->getUsername() ) ?>
        </div>
      </div>
     <?php endif;?>
   </div>
</div>
<?php include_partial('friends/horizontal_ad')?>
