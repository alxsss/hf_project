<?php use_helper('Form','I18N', 'Global')?>
<div id="left_column_user"> 
  <?php include_component('sfSocialEvent', 'elinks')?>
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
          <?php echo pager_navigation($allmembers_pager, '@event_'.$sf_param('action').'?id='.$event->getId()) ?>
        </div>
      </div>
    <?php endif;?>     
 </div>
</div>
