<?php use_helper('Global') ?>
<h3><?php echo $subscriber?>'s videos</h3>
<?php foreach ($videos_pager->getResults() as $video): ?>
  <?php $video_filename=$video->getFilename();?>	
    <?php if(!empty($video_filename)): ?>
      <?php $video_thumb_url='/uploads/assets/videos/thumbnails/'.$video_filename.'.png'?>
	<?php else:?>
      <?php $video_thumb_url='/uploads/assets/photos/thumbnails/no_photo.jpg'?>
	<?php endif; //if !empty lastPhoto?>
	<div class="user_video">
	  <div class="video_image">
         <?php echo link_to(image_tag($video_thumb_url, ''), 'videos/show?id='.$video->getId())?>
	  </div>
	  <div class="user_video_title"><?php echo $video->getTitle()?></div>		
    </div>
<?php endforeach; ?>

<div class="pagination">
  <div id="photos_pager">
    <?php echo pager_navigation($videos_pager, 'video/list') ?>
  </div>
</div>

