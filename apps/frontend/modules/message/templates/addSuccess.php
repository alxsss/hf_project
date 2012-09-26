<?php use_helper('Status', 'Date') ?>
<?php if(isset($message)): ?>
<?php $photo=$message->getsfGuardUserRelatedByFromUserid()->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
<div class="user_status_photo">
  <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'style="clear:both; " alt=no img'), 'user/'.$message->getsfGuardUserRelatedByFromUserid()) ?>
</div>  
<div class="message_text">
  <div class="update_username">
	<?php echo link_to($message->getsfGuardUserRelatedByFromUserid(), 'user/'.$message->getsfGuardUserRelatedByFromUserid())?> <span style="font-size:11px;color:#777;font-weight:normal;"><?php echo format_date($message->getCreatedAt(),'f')?></span>
  </div>	     		
   <?php echo nl2br($message->getMsgtext()) ?>
</div>
<?php endif; ?>