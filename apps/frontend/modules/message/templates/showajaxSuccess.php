<?php use_helper('Global', 'I18N', 'Date') ?>
  <?php $messages_pager->getLinks()//this is done to correctly count getCurrentMaxLink()?>
  <?php if (($messages_pager->haveToPaginate())&&($messages_pager->getPage() != $messages_pager->getFirstPage()) ):?>
    <div class="user_updates" style="margin:0">
	  <?php echo link_to(__('Previous Messages'), 'message/showajax?id='.$id.'&fromuserid='.$fromuserid.'&page='.$messages_pager->getPreviousPage(), 'class=previous_messages') ?>     
    </div>
  <?php endif;?>
  <?php foreach($messages_pager->getResults() as $message):?>
    <?php if($message->getReadUnread()==0)://mark message as read?>
      <?php $message->setReadUnread(1);?>
      <?php $message->save();?>
    <?php endif;?>
    <?php $photo=$message->getsfGuardUserRelatedByFromUserid()->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
    <div class="user_message">
      <div class="user_status_photo">	   
	    <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'style="clear:both; " alt=no img'), 'user/'.$message->getsfGuardUserRelatedByFromUserid()) ?>
	  </div>  
      <div class="message_text">
	      <div class="update_username">
	        <?php echo link_to($message->getsfGuardUserRelatedByFromUserid(), 'user/'.$message->getsfGuardUserRelatedByFromUserid())?> <span style="font-size:11px;color:#777;font-weight:normal;"><?php echo format_date($message->getCreatedAt(),'f')?></span>
	      </div>	     		
	      <?php echo nl2br($message->getMsgtext()) ?>
	  </div>
    </div>   
  <?php endforeach;?>
