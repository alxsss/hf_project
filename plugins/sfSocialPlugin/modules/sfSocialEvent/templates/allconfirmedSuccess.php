<?php use_helper('Global', 'I18N') ?>
<div id="updates_left_column">
<?php if($sf_user->isAuthenticated()):?> 
 <?php include_component('sfSocialGroup', 'glinks')?>  
<?php else:?>
  <?php include_partial('home/inhemsinif')?>	    
<?php endif;?>
</div>
<div id="right_column_user">
  <?php foreach ($allmembers_pager->getResults() as $member): ?>
    <div class="all_users">
     <?php $photo=$member->getsfGuardUser()->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';}?>
      <div class="user_album_title"><?php  echo link_to($member->getsfGuardUser(), 'user/'.$member->getsfGuardUser() ) ?></div>
        <div class="friend_img">
          <?php  echo link_to(image_tag('/uploads/assets/avatars/normal/'.$photo, 'class=border_image'), 'user/'.$member->getsfGuardUser()) ?>		  
	    </div>
     </div>	
  <?php endforeach; ?>
  <?php if($allmembers_pager->haveToPaginate()): ?>
    <div class="pagination">
     <div id="photos_pager">
       <?php echo pager_navigation($allmembers_pager, '@group_allmembers') ?>
     </div>
    </div>
 <?php endif; ?>
</div>
