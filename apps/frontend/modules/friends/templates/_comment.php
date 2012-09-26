<?php use_helper('Date', 'Global', 'Status', 'Javascript', 'User') ?>
<?php foreach ($comments as $comment): ?>
  <div class="comments">
    <?php $photo=$comment->getsfGuardUser()->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
	<div class="status_comment_photo">
      <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'alt=no img width=30px height=30px'), 'user/'.$comment->getsfGuardUser()->getUsername()) ?>
	</div>
	<?php echo link_to($comment->getsfGuardUser()->getUsername(), 'user/'.$comment->getsfGuardUser()->getUsername()) ?>
	<span class="comment_dates">
      (<?php echo status_date($comment->getCreatedAt('U'), $comment->getCreatedAt('F j, Y'))?>) 
    </span>  
    <div class="comment_text">
	  <?php echo $comment->getComment() ?>
	  <?php if($user_id==$status->getUserId()||$user_id==$comment->getUserId()):?> 
	    <div class="comment_actions">
          <?php  echo link_to_remote(__('Delete'), array(
	         'url'=> '@delete_status_comment?id='.$comment->getId().'&index='.$index, 
			 'update' => 'add_status_comment_'.$index,
             'loading'  => "Element.show('indicator')",
             'complete' => visual_effect('highlight', 'add_status_comment_'.$index),
            )) ?> 
	    </div>		  
     <?php endif;?>
   </div>
  </div>
<?php endforeach; ?>
