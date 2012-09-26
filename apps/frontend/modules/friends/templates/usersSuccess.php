<?php use_helper('Global', 'I18N') ?>
<div id="updates_left_column">
<?php if($sf_user->isAuthenticated()):?> 
 <?php include_component('friends', 'ulinks')?>  
<?php else:?>
  <?php include_partial('home/inhemsinif')?>	    
<?php endif;?>
</div>
<div id="right_column_user">
  <div class="friends_to_be_invited">
    <div class="friends_to_be_invited_line"><?php $cnt=0;?>
    <?php foreach ($user_pager->getResults() as $user): ?>
      <?php $cnt++;?>
      <div class="user_friend">
	  <?php $photo=$user->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';}?>
      <div class="user_album_title"><?php  echo link_to($user, 'user/'.$user ) ?></div>
        <div class="friend_img">
          <?php  echo link_to(image_tag('/uploads/assets/avatars/normal/'.$photo, 'class=border_image'), 'user/'.$user) ?>		  
	    </div>
     </div>	
     <?php if($cnt==7){echo '</div><div class="friends_to_be_invited_line">';$cnt=0;}?>
  <?php endforeach; ?>
 </div>
  <div class="pagination">
   <div id="photos_pager">
     <?php echo pager_navigation($user_pager, '@all_users') ?>
   </div>
  </div>
</div>
</div>
<?php include_partial('friends/horizontal_ad')?>