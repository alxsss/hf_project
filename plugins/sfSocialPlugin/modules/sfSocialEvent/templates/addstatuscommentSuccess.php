<?php use_helper('Status', 'Date') ?>
<?php $photo=$comment->getsfGuardUser()->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
<div class="status_comment_photo">
  <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'alt=no img'), 'user/'.$comment->getsfGuardUser()->getUsername()) ?>
</div>
<?php echo link_to($comment->getsfGuardUser()->getUsername(), 'user/'.$comment->getsfGuardUser()->getUsername()) ?>
<span class="comment_dates">(<?php echo status_date($comment->getCreatedAt('U'), $comment->getCreatedAt('F j, Y'))?>)</span>  
<div class="comment_text">
  <?php echo $comment->getComment() ?>
  <?php if($user_id==$comment->getEventStatus()->getsfSocialEvent()->getUserAdmin()||$user_id==$comment->getUserId()):?> 
    <div class="delete_comment">
      <?php  echo link_to(__('Delete'), '@delete_event_status_comment?id='.$comment->getId()) ?> 
	</div>		    
  <?php endif;?>
</div>  
