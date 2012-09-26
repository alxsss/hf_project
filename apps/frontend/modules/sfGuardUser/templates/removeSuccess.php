<?php use_helper('Javascript') ?>
<h3>Favorite photos</h3>
<?php foreach ($fav_photos as $fav_photo): ?>
  <?php $pic_url='/uploads/assets/photos/thumbnails/'.$fav_photo->getPhoto()->getFilename()?>
  <div class="user_album" onMouseOut="return fav_photo_del_invisible(<?php echo $fav_photo->getPhotoId()?>)"  onMouseOver="return fav_photo_del_visible(<?php echo $fav_photo->getPhotoId()?>)">
    <div class="album_image">
        <?php echo link_to(image_tag($pic_url, ''), 'photos/show?id='.$fav_photo->getPhoto()->getId())?>		 
	</div>
	<?php if($user_id==$subscriber->getId()):?>
		<div class="fav_photo_del" id="fav_photo_del_<?php echo $fav_photo->getPhotoId()?>">
            <?php echo link_to_remote('[x]', array(
          'url'      => '@fav_photo_remove?id='.$fav_photo->getPhoto()->getId().'&username='.$subscriber,
          'update'   => 'favorite_photos',
  		  'confirm'  => 'Do you want to remove this photo?',
          'loading'  => "Element.show('indicator')",
          'complete' => visual_effect('highlight', 'favorite_photos'),
        )) ?> 
		</div>
		<?php endif;?> 
  </div>	
<?php endforeach; ?>