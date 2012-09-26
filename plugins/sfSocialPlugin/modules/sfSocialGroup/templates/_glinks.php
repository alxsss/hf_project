  <div class="user_profile_picture">
    <?php $photo=$group->getPhoto();if(empty($photo)){$photo='no_img.gif';} ?>
    <?php  echo link_to(image_tag('/uploads/assets/avatars/'.$photo, 'alt=no img'), '@sf_social_group?id='.$group->getId()) ?>
    <div class="user_album_title">
       <?php echo $group->getTitle() ;?>
    </div>		
  </div>
  <div class="user_contact"> 
    <?php echo link_to(__('home'), '@sf_social_group?id='.$group->getId(), 'class=user_links')?>
    <?php if (!$group->isMember($user_id)): ?>
       <?php if ($group->isInvited($user_id)): ?>
	 <?php echo link_to(__('accept invite'), '@sf_social_group_accept?id=' . $group->getInvite($user_id), 'class=user_links') ?>
	 <?php echo link_to(__('deny invite'), '@sf_social_group_deny?id=' . $group->getInvite($user_id), 'class=user_links') ?>
       <?php elseif(!$group->getVisibility()): ?>
	 <?php echo link_to(__('join group'), '@sf_social_group_join?id=' . $group->getId(), 'class=user_links') ?>
       <?php endif ?>
    <?php else: ?>    
       <?php echo link_to(__('suggest to friends'),'@suggest?id='.$group->getId(), 'class=user_links')?>
    <?php endif;?>
    <?php if($group->isAdmin($user_id)): ?>
      <?php echo link_to(__('edit group'), '@sf_social_group_edit?id=' . $group->getId(), 'class=user_links')?>
      <?php echo link_to(__('edit members'), '@group_edit_members?id='.$group->getId(), 'class=user_links')?>
    <?php endif;?>
    <?php if(!$group->isAdmin($user_id)&&$group->isMember($user_id)): ?>
      <?php echo link_to(__('leave group'),'@leave_group?id='.$group->getId(), 'class=user_links')?>
    <?php endif;?>      
  </div>     
 
  <div class="left_boxes">
    <div class="left_boxes_title"><?php $num_members=$group->countsfSocialGroupUsers()?><?php echo __('members').'('.$num_members.')'?></div>
	    <?php $c=new Criteria(); $c->setLimit(6)?>
   <?php if (null === $members = $group->getsfSocialGroupUsers($c)): ?>
      <?php echo __('No members', null, 'sfSocial') ?>
    <?php else: ?>
      <div class="group_members">
        <div class="members_line">
          <?php foreach ($members as $i=>$groupUser): ?>
            <div class="group_member">           
              <?php echo link_to(image_tag($groupUser->getsfGuardUser()->getThumb(), 'title=' . $groupUser->getsfGuardUser() . ' alt=' . $groupUser->getsfGuardUser()), url_for('user/'.$groupUser->getsfGuardUser()) ) ?>
             <div class="group_member_title">
                           <a href="<?php echo url_for('@user_profile?username='.$groupUser->getsfGuardUser())?>" > <?php echo mb_substr($groupUser->getsfGuardUser(), 0, 9,'UTF-8').'<wbr>'.mb_substr($groupUser->getsfGuardUser(), 9, strlen($groupUser->getsfGuardUser()), 'UTF-8') ?></a>
             </div>
	   </div>
          <?php if($i==2){echo '</div><div class="members_line">';}?>
         <?php endforeach ?>
        </div>
      </div>
          <?php endif; ?>
    <?php if($num_members>6):?>
        <div class="see_all"><?php echo link_to(__('see all'), '@group_allmembers?id='.$group->getId())?></div>
    <?php endif; ?>

  </div>
