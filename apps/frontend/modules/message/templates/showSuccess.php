<?php use_helper('Global', 'I18N', 'Date') ?>
<div id="updates_profile_right_column">
  <?php include_partial('links') ?>
  <div class="messages_box">
  
<div class="show_subject"><?php echo __('Subject')?>: <?php echo $subject?></div>
<div class="show_subject">
<?php if($message->getToUserid()==$user_id):?>
  <?php echo link_to(__('Delete'), 'message/deletefrominbox?id='.$message->getId().'&fromuserid='.$message->getFromuserid(), array('class'=>'reply_to_message','post' => true, 'confirm' => __('Are you sure?'))) ?>
<?php else :?>
  <?php echo link_to(__('Delete'), 'message/deletefromsentbox?id='.$message->getId().'&touserid='.$message->getTouserid(), array('class'=>'reply_to_message','post' => true, 'confirm' => __('Are you sure?'))) ?>
<?php endif;?>
</div>
 <?php $messages_pager->getLinks()//this is done to correctly count getCurrentMaxLink()?>
  <?php if (($messages_pager->haveToPaginate())&&($messages_pager->getPage() != $messages_pager->getFirstPage()) ):?>
    <div class="user_updates" style="margin:0;">
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
  <div class="message_new"></div>
    <div class="message_box">
      <h4><?php echo __('Reply')?></h4>
      <div class="error_message"><?php echo __('Required.')?></div>
      <form action="<?php echo url_for('@add_message')?>" method="post">	       
	  <textarea cols="30" rows="3" class="message_box_textarea expand70" 
	  id="message_msgtext" name="message[msgtext]" style="height: 70px; overflow: hidden; padding-top: 0px; padding-bottom: 0px;"></textarea>
	  <input type="hidden" value="<?php echo $subject?>"  name="subject"> 
	  <input type="hidden" value="<?php echo $fromuserid?>"  name="to_userid"> 
	  <input type="hidden" value="<?php echo $user_id?>"  name="from_userid">             
          <div class="submit">      
        <input type="submit" value="<?php echo __('Send')?>" class="message_box_form"> 
      </div>			  
    </form>
  </div>
 </div><!--end messages_box--> 
</div><!--end updates_profile_right_column-->
  <div class="right_ad_boxes">
    <script type="text/javascript"><!--
      google_ad_client = "pub-0181717197672047";
      /* 120x600, created 10/7/10 */
      google_ad_slot = "5283049147";
      google_ad_width = 120;
      google_ad_height = 600;
      //-->
    </script>
    <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
  </div>
