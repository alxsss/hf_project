<?php use_helper('I18N') ?>
<div id="updates_left_column">
<?php if($sf_user->isAuthenticated()):?> 
  <?php include_component('friends', 'ulinks')?>  
<?php else:?>
  <?php include_partial('home/inhemsinif')?>	    
<?php endif;?>
</div>
<div id="right_column_user">
<?php if(count($friend_list)>0):?>
  <div id="updates_status_right_column">
    <?php foreach ($friend_list as $friends): ?>
      <?php $photo=$friends->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
      <div class="search_user">
        <div class="search_user_image">
	   <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'alt=no picture'), 'user/'.$friends->getUsername()) ?>
        </div>
        <div class="search_user_title"><?php  echo link_to($friends->getUsername(), 'user/'.$friends->getUsername()) ?></div>
       <div class="search_sg_links"><?php echo link_to(__('Add to friends'), 'friends/new?friend_id='.$friends->getId())?></div>
     </div>	
    <?php endforeach; ?>
  </div>
  <div id="friend_suggestions">
    <?php include_partial('friends/ad200x200')?>
  </div>
<?php else:?>
   <div class="user_links"><?php echo __('search for %query% did not give any results. You can invite %query% using this link', array('%query%'=>'<b>'.$query.'</b>'))?></div>
   <div class="user_links"><?php echo link_to(__('invite friends'), '@invitefriend')?></div>
<?php endif;?>
</div>
<?php include_partial('friends/horizontal_ad')?>
