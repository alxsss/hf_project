<?php use_helper('Global', 'I18N') ?>
<div id="updates_left_column">
  <div class="user_contact">
    <?php echo link_to($subscriber_username.__('\'s profile'), 'user/'.$subscriber_username, 'class=user_links') ?>
   	<?php echo link_to( __('All albums by %author%', array('%author%'=>$subscriber_username)), '@all_albums?username='.$subscriber_username, 'class=user_links')?>
	<?php echo link_to( __('All photos by %author%', array('%author%'=>$subscriber_username)), '@all_photos?username='.$subscriber_username, 'class=user_links')?>
  </div> 
<?php if($sf_user->isAuthenticated()):?> 
 <?php include_component('friends', 'ulinks')?>
<?php else:?>
  <?php include_partial('home/inhemsinif')?>	    
<?php endif;?>
</div>
<div id="right_column_user">
  <div class="friends_to_be_invited">
  <div class="friends_to_be_invited_line"><?php $cnt=0;?>
    <?php foreach ($friend_pager->getResults() as $friend): ?>
      <?php $cnt++;?>
      <div class="user_friend">
        <?php if($friend->getUserId()==$username_user_id):?>
          <?php $friendUser=sfGuardUserPeer::retrieveByPk($friend->getFriendId()); ?>
	     <?php $photo=$friendUser->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';}?>
             <div class="user_album_title"><?php  echo link_to($friendUser, 'user/'.$friendUser ) ?></div>
             <div class="album_image" style="width:76px;border:none;padding:0px">
               <?php  echo link_to(image_tag('/uploads/assets/avatars/normal/'.$photo), 'user/'.$friendUser) ?>		  
	      </div>
	      <?php if($sf_user->isAuthenticated()&&($user_id==$username_user_id)):?>
		  <div class="friend_del"><a  href="#"  title="<?php echo __('Delete')?>"  user_id="" friend_id="<?php echo $friend->getFriendId()?>">[x]</a></div>
	     <?php endif;?> 	
        <?php elseif($friend->getFriendId()==$username_user_id):?>
          <?php $friendUser=sfGuardUserPeer::retrieveByPk($friend->getUserId()); ?>
	  <?php $photo=$friendUser->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';}?>
          <div class="user_album_title"><?php  echo link_to($friendUser, 'user/'.$friendUser ) ?></div>
          <div class="album_image" style="width:76px;border:none;padding:0px">
            <?php  echo link_to(image_tag('/uploads/assets/avatars/normal/'.$photo), 'user/'.$friendUser) ?>		  
	   </div>
	   <?php if($sf_user->isAuthenticated()&&($user_id==$username_user_id)):?>
	     <div class="friend_del"><a  href="#"  title="<?php echo __('Delete')?>"  friend_id="" user_id="<?php echo $friend->getUserId()?>">[x]</a></div>
	   <?php endif;?> 	
        <?php endif;?>           	  
      </div>
      <?php if($cnt==7){echo '</div><div class="friends_to_be_invited_line">';$cnt=0;}?>	
    <?php endforeach; ?>
  </div>
  <?php if($friend_pager->haveToPaginate()):?>
    <div class="pagination">
     <div id="photos_pager">
       <?php echo pager_navigation($friend_pager, '@all_friends?username='.$subscriber_username) ?>
     </div>
    </div>
  <?php endif;?>           	  
</div>
</div>
<?php include_partial('friends/horizontal_ad')?>
