  <div class="user_contact">
    <div class="user_links"><?php echo link_to(__('upload a photo'), '@upload') ?> </div>
 	<div class="user_links"><?php echo link_to(__('find your school'), 'school/list');?></div>
	<div class="user_links"><?php echo link_to(__('edit profile'), 'profile/'.$subscriber->getSalt()) ?></div>
	<div class="user_links"><?php echo link_to(__('invite friends'), '@invitefriend')?></div>
	<div class="user_links"><?php echo link_to(__('messages').'('.$inbox_num_msgs.')', '@user_inbox') ?></div>       
    <div class="user_links"><?php /*if($num_friendsRequests) */echo link_to(__('friend requests').'('.$num_friendsRequests.')', 'friends/list') ?></div>
	<div class="user_links"><?php echo link_to(__('guests').'('.$num_guests.')', '@guest') ?></div>
	<div class="user_links"><?php echo link_to(__('rates').'('.$num_rates.')', '@ratings') ?></div>
	<div class="user_links"><?php //echo link_to(__('Create a new group', null, 'sfSocial'), '@sf_social_group_new') ?></div>
  </div>