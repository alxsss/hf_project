<?php use_helper('Status', 'Date')?>
 <div class="user_profile_picture">
    <?php $photo=$subscriber->getProfile()->getPhoto();  if(empty($photo)){$photo='no_img.gif';} ?>
    <?php  echo image_tag('/uploads/assets/avatars/'.$photo, 'alt=no img') ?>
    <div class="user_album_title">
      <?php $name= $subscriber->getProfile()->getName()?>
      <?php $name= trim($name)?>
      <?php if(!empty($name)):?>
        <?php echo $name ?>
      <?php else:?>
        <?php echo $subscriber ;?>
      <?php endif;?>
	</div>	
	<?php if($subscriber->getSession()&&time()-$subscriber->getSession()->getSessTime()<300):?>
	  <div class="user_last_login"><?php echo image_tag('onlinenow.gif').__('online')?></div>
	<?php else:?>
	  <div class="user_last_login"><?php echo __('last login')?> <span class="status_date"><?php echo status_date($subscriber->getLastLogin('U'), format_date($subscriber->getLastLogin(), 'p'))?></span></div>
	<?php endif;?>
  </div>
  <div class="user_contact">
    <?php if($user_id!=$subscriber->getId()):?>
      <?php echo link_to(__('Send a message'), 'message/create?to_userid='.$subscriber->getId(), 'class=user_links')?>
      <?php echo link_to(__('Add to friends'), 'friends/new?friend_id='.$subscriber->getId(), 'class=user_links')?>
    <?php else :?>
        <?php echo link_to(__('upload a photo'), '@upload', 'class=user_links') ?> 
 	<?php echo link_to(__('add your school'), 'school/list', 'class=user_links');?>
	<?php echo link_to(__('edit profile'), 'profile/'.$subscriber->getSalt(), 'class=user_links') ?>
	<?php echo link_to(__('messages').($inbox_num_msgs?'(<span class="ulinks_color">'.$inbox_num_msgs.'</span>)':''), '@user_inbox', 'class=user_links') ?>
    <?php echo link_to(__('suggestions').($num_requests?'(<span class="ulinks_color">'.$num_requests.'</span>)':''), 'friends/list', 'class=user_links') ?>
	<?php echo link_to(__('guests').($num_guests?'(<span class="ulinks_color">'.$num_guests.'</span>)':''), '@guest', 'class=user_links') ?>
	<?php echo link_to(__('rates').($num_rates?'(<span class="ulinks_color">'.$num_rates.'</span>)':''), '@ratings', 'class=user_links') ?>
  	<?php echo link_to(__('edit friends'), '@all_friends?username='.$subscriber, 'class=user_links')?>
	<?php echo link_to(__('invite friends'), '@invitefriend', 'class=user_links')?>
    <?php endif; ?>
  </div>
