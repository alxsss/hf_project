<?php use_helper('Form','I18N', 'Global')?>
<?php /* escaping strategy safety */ //$_user = $user instanceof sfGuardUser ? $user : $user->getRawValue() ?>
<div id="left_column_user"> 
  <?php include_component('sfSocialGroup', 'glinks')?>
</div>
<div id="right_column_user">
  <?php //if ($group->isMember($_user)): ?>
  <div class="all_photos"><?php echo __('Invite') ?></div>
  <div class="all_photos"><input type="button" value="<?php echo __('Select/Unselect All')?>" name="friend_invite" id="friend_invite" class="reply_to_message"/></div>
  <div id="group_invite">
    <form id="invites" action="<?php echo url_for('@sf_social_group_invite?id=' . $group->getId()) ?>" method="post">
      <input type="hidden" value="<?php echo $group->getId()?>" name="group_id"/>
      <div class="friends_to_be_invited">
        <div class="friends_to_be_invited_line"><?php $cnt=0;?>
          <?php foreach ($friend_pager->getResults() as $friend): ?>
            <?php $cnt++;?>
            <div class="user_friend">
              <?php if($friend->getUserId()==$user_id):?>
                <?php $friendUser=sfGuardUserPeer::retrieveByPk($friend->getFriendId()); ?>
	        <?php $photo=$friendUser->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';}?>
                <div class="user_album_title"><?php  echo link_to($friendUser, 'user/'.$friendUser ) ?></div>
                <div class="album_image" style="width:76px;border:none;padding:0px">
                  <?php  echo link_to(image_tag('/uploads/assets/avatars/normal/'.$photo), 'user/'.$friendUser) ?>		  
	        </div>
	        <?php if(!($group->isInvited($friend->getFriendId())||$group->isMember($friend->getFriendId()))):?>
	          <input type="checkbox" value="<?php echo $friend->getFriendId()?>" name="markinvite[]" id="markinvite" class="inputcheckbox"/>
	        <?php endif;?> 	
              <?php elseif($friend->getFriendId()==$user_id):?>
                 <?php $friendUser=sfGuardUserPeer::retrieveByPk($friend->getUserId()); ?>
	         <?php $photo=$friendUser->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';}?>
                 <div class="user_album_title"><?php  echo link_to($friendUser, 'user/'.$friendUser ) ?></div>
                 <div class="album_image" style="width:76px;border:none;padding:0px">
                   <?php  echo link_to(image_tag('/uploads/assets/avatars/normal/'.$photo), 'user/'.$friendUser) ?>		  
	         </div>
	         <?php if(!($group->isInvited($friend->getUserId())||$group->isMember($friend->getUserId()))):?>
	           <input type="checkbox" value="<?php echo $friend->getUserId()?>" name="markinvite[]" id="markinvite" class="inputcheckbox"/>
	         <?php endif;?> 	
              <?php endif;?>           	  
           </div>
          <?php if($cnt==7){echo '</div><div class="friends_to_be_invited_line">';$cnt=0;}?>	
         <?php endforeach; ?>
      </div>
    </div>
    <div style="clear:both;margin:10px 20px;"><input type="submit" value="<?php echo __('invite') ?>" /> </div>
    <?php if ($friend_pager->haveToPaginate()): ?>
      <div class="pagination">
        <div id="photos_pager">
          <?php echo pager_navigation($friend_pager, '@suggest?id='.$group->getId()) ?>
        </div>
      </div>
    <?php endif;?>     
 </form>
 </div>
</div>
<script type="text/javascript">
function toggleCheckboxes(buttonId, checkBoxNamePrefix, checked)
    {
      //Get all checkboxes with the prefix name and check/uncheck
      jQuery('[id*=' + checkBoxNamePrefix + ']').attr('checked', checked);

      //remove any click handlers from the button
      //  Why?  Because jQuery(buttonId).click() will just add another handler
      jQuery(buttonId).unbind('click'); 

      //Add the new click handler
      jQuery(buttonId).click(
        function() {
          toggleCheckboxes(buttonId, checkBoxNamePrefix, !checked);
        }
      );
    }
</script>
