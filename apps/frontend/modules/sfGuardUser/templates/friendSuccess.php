<?php use_helper('Text', 'I18N') ?>
<?php include_partial('sfGuardUser/profile_links', array('subscriber' => $subscriber, 'inbox_num_msgs' => $inbox_num_msgs, 'num_guests'=>$num_guests, 'num_rates'=>$num_rates,
'num_friendsRequests'=>$num_friendsRequests, 'user_id'=>$user_id)) ?>

<div id="right_column_user">
<div id="updates_profile_right_column">
   <?php if(($subscriber->getProfile()->getVisibility())&&!(($subscriber->isFriend($user_id))||($user_id==$subscriber->getId()))):?>
   <div class="private_profile">
   <?php echo __('This profile is set to private')?>
   </div>
 <?php else:?>
  <div class="ifp_nav">
    <ul>
	  <li><?php echo link_to(__('Info'), 'info/'.$subscriber) ?></li>
	  <li class="selected"><?php echo link_to(__('Friends'), 'friend/'.$subscriber) ?></li>
	  <li class="last_nb"><?php echo link_to(__('Photos'), 'photo/'.$subscriber) ?></li>
	</ul>
  </div>

  <div class="profile_section_nb">
    <span class="recent_activity"><?php echo __('Friends')?>(<?php echo $num_friends?>)</span>   
    <div class="friends_to_be_invited_line">
     <?php foreach ($user_friends as $user_friend): ?>
      <?php $photo=$user_friend->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
      <div class="user_friend">
        <div class="user_album_title"><?php  echo link_to($user_friend, 'user/'.$user_friend ) ?></div>
           <?php  echo link_to(image_tag('/uploads/assets/avatars/normal/'.$photo, 'alt=no img class=border_image'), 'user/'.$user_friend) ?>		  
	    </div>	
    <?php endforeach; ?>	
    </div>
    <?php if($num_friends>5):?>
	 <div class="see_all_profile"> <?php echo link_to(__('see all'), '@all_friends?username='.$username)?></div>	
	<?php endif;?>	        	
  </div>   

 <?php endif;?>
 </div><!--updates_status_right_column-->

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

</div><!--right_column-->
