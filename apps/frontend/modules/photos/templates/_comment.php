<?php use_helper('Date', 'Status', 'I18N') ?>
 <?php include_partial('sidebar/signin')?>

<?php foreach ($comments as $comment): ?>
  <div class="items comments">
    <?php $photo=$comment->getsfGuardUser()->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
	<div class="status_comment_photo">
      <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'alt=no img'), 'user/'.$comment->getsfGuardUser()->getUsername()) ?>
	</div>
	<?php echo link_to($comment->getsfGuardUser()->getUsername(), 'user/'.$comment->getsfGuardUser()->getUsername()) ?>
	<span class="comment_dates">
      (<?php echo status_date($comment->getCreatedAt('U'), $comment->getCreatedAt('F j, Y'))?>) 
    </span>  
    <div class="comment_text">
	  <div class="comment_body"><?php echo $comment->getComment() ?></div>
	  <?php if($user_id==$photos->getUserId()||$user_id==$comment->getUserId()):?> 
	    <div class="delete_item">
          <?php  echo link_to(__('Delete'), '@delete_photo_comment?id='.$comment->getId()) ?> 
	    </div>		    
     <?php endif;?>
   </div>
  </div>
<?php endforeach; ?>
