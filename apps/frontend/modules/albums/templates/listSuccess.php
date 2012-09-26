<?php use_helper('I18N', 'Global') ?>
<div id="updates_left_column">
<div class="user_contact">
  <!--in case if a user is not signed in and album is visible $user_id is not defined-->
  <?php echo link_to($album_owner->getUsername().__('\'s profile'), 'user/'.$album_owner->getUsername(), 'class=user_links')?>	
  <?php echo link_to(__('All photos by %author%', array('%author%'=>$album_owner->getUsername())),'@all_photos?username='.$album_owner->getUsername(), 'class=user_links')?>
  <?php echo link_to( __('All albums by %author%', array('%author%'=>$album_owner->getUsername())), '@all_albums?username='.$album_owner->getUsername(), 'class=user_links')?>
</div> 

<?php if($sf_user->isAuthenticated()):?> 
 <?php include_component('friends', 'ulinks')?>  
<?php else:?>
  <?php include_partial('home/inhemsinif')?>	    
<?php endif;?>
</div>
<div id="right_column_user">
<div class="all_photos"><?php echo __('All albums by %author%', array('%author%'=>$album_owner->getUsername()))?></div>
  <div class="friends_to_be_invited">
    <div class="friends_to_be_invited_line"><?php $cnt=0;?>
<?php foreach ($albums->getResults() as $album): ?>
 <?php $cnt++;?>
  <?php $visibility=$album->getVisibility();?>
  <?php //check  if album has visibility 1?>
  <?php if($visibility):?>
    <?php //in this case album is visible only to friends. Check  if  signed user is a friend to this user?>
	<?php if($album_owner->isFriend($user_id)||($user_id===$album_owner->getId())):?>
      <?php $lastPhoto=$album->getLastPhoto();?>
      <?php if(!empty($lastPhoto)): ?>
        <?php $pic_url='/uploads/assets/photos/thumbnails/'.$lastPhoto->getFilename()?>
	  <?php else:?>
       <?php $pic_url='/uploads/assets/photos/thumbnails/no_photo.jpg'?>
	 <?php endif; //if !empty lastPhoto?>
	  <div class="user_friend">
	    <a href="<?php echo url_for('albums/show?id='.$album->getId())?>">	  
	      <div class="album_image">
            <?php echo image_tag($pic_url, 'alt=no img class=image_with_border')?>
		  </div>		
		</a>	
		<div class="user_album_title"><?php   echo $album->getTitle(); ?></div>
		<div class="user_album_countPhotos"><?php echo $album->countPhotos(); ?> photos</div>
	  </div>	
  <?php endif; //if friend ?>
  
<?php else: ?>
  <?php $lastPhoto=$album->getLastPhoto();?>
  <?php if(!empty($lastPhoto)): ?>
     <?php $pic_url='/uploads/assets/photos/thumbnails/'.$lastPhoto->getFilename()?>
  <?php else:?>
     <?php $pic_url='/uploads/assets/photos/thumbnails/no_photo.jpg'?>
  <?php endif; //if !empty lastPhoto?>
   <div class="user_friend">
     <a href="<?php echo url_for('albums/show?id='.$album->getId())?>">	  
	   <div class="album_image">
         <?php echo image_tag($pic_url, 'alt=no img class=image_with_border')?>
	    </div>		
	  </a>
	<div class="user_album_title"><?php echo $album->getTitle(); ?></div>
	<div class="user_album_countPhotos"><?php echo __('photos')?> <?php echo $album->countPhotos(); ?></div>
  </div>	
<?php endif; //if visibility?>
<?php if($cnt==7){echo '</div><div class="friends_to_be_invited_line">';$cnt=0;}?>	
<?php endforeach; ?>
</div>
 <?php if($albums->haveToPaginate()):?>
  <div class="pagination">
    <div id="photos_pager">
      <?php echo pager_navigation($albums, '@all_albums?username='.$album_owner->getUsername() ) ?>
    </div>
  </div>
  <?php endif;?>
</div>
</div>
<?php include_partial('friends/horizontal_ad')?>
