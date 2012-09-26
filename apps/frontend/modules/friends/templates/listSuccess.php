<?php  use_helper('I18N', 'Text');?>
<div id="updates_left_column">
 <?php include_component('friends', 'ulinks')?>  
</div>
<div id="right_column_user">
<?php if(count($friendsRequested)>0):?>
<div class="all_photos"><?php echo __('friend requests')?></div>
<div class="friends_requested">
  <?php foreach ($friendsRequested as $friend): ?>
    <?php $friendUser= $friend->getFriend($friend->getUserId());?>
    <?php $photo=$friendUser->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
    <div class="request">
     <div class="user_friend" style="height:auto;">
	   <div class="user_friend_title">  <?php  echo link_to($friendUser, 'user/'.$friendUser ) ?></div>
	   <div class="friend_request_image">
           <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'alt=no picture class=friend_request'), 'user/'.$friendUser) ?>
         </div>
       </div>
       <div class="request_functions">
         <div class="find_friend_approve">
           <a  class="approve" href="<?php echo url_for('@friend_approve')?>" id="<?php echo $friend->getId()?>" item_id="<?php echo $friendUser->getId()?>"><?php echo __('Approve')?></a>	    
         </div>
         <div class="find_friend_ignore">
           <a  class="deny" href="<?php echo url_for('friends/delete?id='.$friend->getId())?>"> <?php echo __('Deny')?></a>	    
         </div>
       </div>
    </div>
  <?php endforeach; ?>
</div>
<?php endif;?>
<?php if(count($group_invites)>0):?>
 <div class="all_photos"><?php echo __('group invites')?></div>
<div class="friends_requested"> 
  <?php foreach ($group_invites as $group_invite): ?>
    <?php $photo=$group_invite->getsfSocialGroup()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
      <div class="request">
	    <div class="user_friend" style="height:auto;">
          <div class="user_friend_title"> <?php  echo link_to(truncate_text($group_invite->getsfSocialGroup()->getTitle(), 50), '@sf_social_group?id='.$group_invite->getGroupId()) ?></div>
          <div class="friend_request_image">
            <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'alt=no picture class=friend_request'),'@sf_social_group?id='.$group_invite->getGroupId()) ?>
          </div>
		</div>  
        <div class="request_functions">
          <div class="find_friend_approve">
            <a  class="approve" href="<?php echo url_for('@sf_social_group_accept')?>" id="<?php echo $group_invite->getId()?>" item_id=1><?php echo __('Approve')?></a>	 
          </div>
          <div class="find_friend_ignore">
            <a  class="deny" href="<?php echo url_for('@sf_social_group_deny?id='.$group_invite->getId())?>"> <?php echo __('Deny')?></a>	    
          </div>
        </div>
     </div>
  <?php endforeach; ?>
</div>
<?php endif;?>
<?php if(count($event_invites)>0):?>
 <div class="all_photos"><?php echo __('event invites')?></div>
<div class="friends_requested"> 
  <?php foreach ($event_invites as $event_invite): ?>
    <?php $photo=$event_invite->getsfSocialEvent()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
      <div class="request">
	    <div class="user_friend" style="height:auto;">
          <div class="user_friend_title"> <?php  echo link_to(truncate_text($event_invite->getsfSocialEvent()->getTitle(), 50), '@sf_social_event?id='.$event_invite->getEventId()) ?></div>
          <div class="friend_request_image">
            <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'alt=no picture class=friend_request'),'@sf_social_event?id='.$event_invite->getEventId()) ?>
          </div>
		</div>  
        <div class="request_functions">
          <div class="find_friend_approve">
            <a  href="<?php echo url_for('@sf_social_event?id='.$event_invite->getEventId())?>" ><?php echo __('Respond')?></a>	 
          </div>
        </div>
     </div>
  <?php endforeach; ?>
</div>
<?php endif;?>
</div>
<?php include_partial('friends/horizontal_ad')?>