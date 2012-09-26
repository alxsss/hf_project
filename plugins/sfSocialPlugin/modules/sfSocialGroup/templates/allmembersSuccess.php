<?php use_helper('Global', 'I18N') ?>
<div id="updates_left_column">
<?php if($sf_user->isAuthenticated()):?> 
 <?php include_component('sfSocialGroup', 'glinks')?>  
<?php else:?>
  <?php include_partial('home/inhemsinif')?>	    
<?php endif;?>
</div>
<div id="right_column_user">
   <div id="group_invite">
      <div class="friends_to_be_invited">
        <div class="friends_to_be_invited_line"><?php $cnt=0;?>
          <?php foreach ($allmembers_pager->getResults() as $member): ?>
            <?php $cnt++;?>
            <div class="user_friend">
                <?php $user=sfGuardUserPeer::retrieveByPk($member->getUserId()); ?>
                 <?php $photo=$user->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';}?>
                 <div class="user_album_title"><?php  echo link_to($user, 'user/'.$user ) ?></div>
                 <div class="album_image" style="width:76px;border:none;padding:0px">
                   <?php  echo link_to(image_tag('/uploads/assets/avatars/normal/'.$photo), 'user/'.$user) ?>
                 </div>
           </div>
          <?php if($cnt==7){echo '</div><div class="friends_to_be_invited_line">';$cnt=0;}?>
         <?php endforeach; ?>
      </div>
    </div>
    <?php if ($allmembers_pager->haveToPaginate()): ?>
      <div class="pagination">
        <div id="photos_pager">
          <?php echo pager_navigation($allmembers_pager, '@group_allmembers?id='.$group_id) ?>
        </div>
      </div>
    <?php endif;?>
 </div>
