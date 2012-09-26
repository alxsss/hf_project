<?php use_helper('I18N', 'Global') ?>
<div id="updates_left_column">
<div class="user_contact">
  <!--in case if a user is not signed in and album is visible $user_id is not defined-->
  <?php echo link_to($photo_owner->getUsername().__('\'s profile'), 'user/'.$photo_owner->getUsername(), 'class=user_links') ?>
  <?php echo link_to(__('All photos by %author%', array('%author%'=>$photo_owner->getUsername())),'@all_photos?username='.$photo_owner->getUsername(), 'class=user_links')?>
  <?php echo link_to( __('All albums by %author%', array('%author%'=>$photo_owner->getUsername())), '@all_albums?username='.$photo_owner->getUsername(), 'class=user_links')?>
</div> 
<?php if($sf_user->isAuthenticated()):?> 
 <?php include_component('friends', 'ulinks')?>
<?php else:?>
  <?php include_partial('home/inhemsinif')?>	    
<?php endif;?>
</div>
<div id="right_column_user">
<div class="all_photos"><?php echo __('All photos by %author%', array('%author%'=>$photo_owner->getUsername()))?></div>
  <div class="friends_to_be_invited">
    <div class="friends_to_be_invited_line"><?php $cnt=0;?>
    <?php foreach ($photos->getResults() as $photo): ?>
	  <?php $cnt++;?>
      <?php $visibility=$photo->getVisibility();?>
      <?php //check  if photo has visibility 1?>
      <?php if($visibility):?>
        <?php //in this case photo is visible only to friends. Check  if  signed user is a friend to this user?>
	    <?php if($photo_owner->isFriend($user_id)||($user_id===$photo_owner->getId())):?>
         <?php $pic_url='/uploads/assets/photos/thumbnails/'.$photo->getFilename()?>
      <div class="user_friend">
	    <a href="<?php echo url_for('photos/show?id='.$photo->getId())?>">
          <div class="album_image">
            <?php echo image_tag($pic_url, 'alt=no img class=image_with_border')?>
	       </div>	
	    </a>	
	  </div>	
  <?php endif; //if friend ?>
  
<?php else: ?>
  <?php $pic_url='/uploads/assets/photos/thumbnails/'.$photo->getFilename()?>
  <div class="user_friend">
    <a href="<?php echo url_for('photos/show?id='.$photo->getId())?>">
      <div class="album_image">
        <?php echo image_tag($pic_url, 'alt=no img class=image_with_border')?>
	  </div>	
	</a>
  </div>	
<?php endif; //if visibility?>
 <?php if($cnt==7){echo '</div><div class="friends_to_be_invited_line">';$cnt=0;}?>	
<?php endforeach; ?>
</div>
 <?php if($photos->haveToPaginate()):?>
<div class="pagination">
  <div id="photos_pager">
    <?php echo pager_navigation($photos, '@all_photos?username='.$photo_owner->getUsername().'&page='.$page ) ?>
  </div>
</div>
<?php endif;?>
</div>
</div>
<?php include_partial('friends/horizontal_ad')?>
