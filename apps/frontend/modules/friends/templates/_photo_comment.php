<?php use_helper('Status', 'Date') ?>
<?php $photo=PhotoPeer::retrieveByPk($photo_id); 
$comments=$photo->getPhotoCommentsJoinsfGuardUser()?>
 
<?php foreach ($comments as $comment): ?>
  <div class="comments items">
    <?php $profile_photo=$comment->getsfGuardUser()->getProfile()->getPhoto();  if(empty($profile_photo)){$profile_photo='no_pic.gif';} ?>
	<div class="status_comment_photo">
      <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$profile_photo, 'alt=no img width=30px height=30px'), 'user/'.$comment->getsfGuardUser()->getUsername()) ?>
	</div>
	<span class="update_username_comment"><?php echo link_to($comment->getsfGuardUser()->getUsername(), 'user/'.$comment->getsfGuardUser()->getUsername()) ?></span>
	<span class="comment_dates">
	      (<?php echo status_date($comment->getCreatedAt('U'), format_date($comment->getCreatedAt(), 'p'))?>) 			            
    </span>  
    <div class="comment_text">
	  <div class="comment_body">
	    <?php echo $comment->getComment() ?>
	  </div>
	  <?php if($user_id==$photo->getUserId()||$user_id==$comment->getUserId()):?> 
	    <div class="delete_item">
          <?php  echo link_to(__('Delete'), '@delete_updates_photo_comment?id='.$comment->getId()) ?> 
	    </div>		  
     <?php endif;?>
   </div>
  </div>
<?php endforeach; ?>
