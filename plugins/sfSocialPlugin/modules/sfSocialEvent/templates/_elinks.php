  <div class="user_profile_picture">
    <?php $photo=$event->getPhoto();if(empty($photo)){$photo='no_img.gif';} ?>
    <?php  echo link_to(image_tag('/uploads/assets/avatars/'.$photo, 'alt=no img'), '@sf_social_event?id='.$event->getId()) ?>
    <div class="user_album_title">
       <?php echo $event->getTitle() ;?>
    </div>		
  </div>
  <div class="user_contact"> 
    <?php echo link_to(__('home'), '@sf_social_event?id='.$event->getId(), 'class=user_links')?>
      <?php echo link_to(__('suggest to friends'),'@suggest_event?id='.$event->getId(), 'class=user_links') ?>
    <?php if($event->isAdmin($user_id)): ?>
      <?php echo link_to(__('edit event'), '@sf_social_event_edit?id=' . $event->getId(), 'class=user_links')?>
    <?php endif;?>      
  </div>  
 <?php $c=new Criteria(); $c->setLimit(6);$confirmed = $event->getConfirmedUsers($c);?>
 <?php if (count($confirmed) > 0): ?>
  <div class="left_boxes">
    <div class="left_boxes_title"><?php echo __('Will participate') ?></div>
         <div class="group_members">
        <div class="members_line">
         <?php foreach ($confirmed as $i=>$eventUser): ?>
           <?php $cUser = $eventUser->getsfGuardUser() ?>
            <div class="group_member">           
              <?php echo link_to(image_tag($cUser->getThumb(), 'alt=' . $cUser . ' title=' . $cUser . ' class=left'), '@user_profile?username=' . $cUser) ?>
              <div class="group_member_title">
 <a href="<?php echo url_for('@user_profile?username='.$cUser)?>" > <?php echo mb_substr($cUser, 0, 9,'UTF-8').'<wbr>'.mb_substr($cUser, 9, strlen($cUser), 'UTF-8') ?></a>
</div>             
	   </div>
          <?php if($i==2){echo '</div><div class="members_line">';}?>
         <?php endforeach ?>
        </div>
      </div>
    <?php if($num_confirmed=count($event->getConfirmedUsers())>6):?>
       <div class="see_all"><?php echo __('members').'('.$num_confirmed.')'?> <span style="float:right;"><?php echo link_to(__('see all'), '@event_allconfirmed?id='.$event->getId()) ?></span></div>
   <?php endif; ?>
  </div>
<?php endif ?>
<?php $maybes = $event->getMaybeUsers($c)?>
<?php if (count($maybes) > 0): ?>
  <div class="left_boxes">
    <div class="left_boxes_title"><?php echo __('Maybe will participate') ?></div>
         <div class="group_members">
        <div class="members_line">
         <?php foreach ($maybes as $i=>$eventUser): ?>
           <?php $cUser = $eventUser->getsfGuardUser() ?>
            <div class="group_member">
             <?php echo link_to(image_tag($cUser->getThumb(), 'alt=' . $cUser . ' title=' . $cUser . ' class=left'), '@user_profile?username=' . $cUser) ?>
             <div class="group_member_title">
              <a href="<?php echo url_for('@user_profile?username='.$cUser)?>" > <?php echo mb_substr($cUser, 0, 9,'UTF-8').'<wbr>'.mb_substr($cUser, 9, strlen($cUser), 'UTF-8') ?></a>
            </div>
           </div>
          <?php if($i==2){echo '</div><div class="members_line">';}?>
         <?php endforeach ?>
        </div>
      </div>
    <?php if($num_confirmed=count($event->getMaybeUsers())>6):?>
       <div class="see_all"><?php echo __('members').'('.$num_confirmed.')'?> <span style="float:right;"><?php echo link_to(__('see all'), '@event_allmayb?id='.$event->getId()) ?></span></div>
   <?php endif; ?>
  </div>
<?php endif ?>

<?php $nots = $event->getNoUsers($c)?>
<?php if (count($nots) > 0): ?>
  <div class="left_boxes">
    <div class="left_boxes_title"><?php echo __('Will not participate') ?></div>
         <div class="group_members">
        <div class="members_line">
         <?php foreach ($nots as $i=>$eventUser): ?>
           <?php $cUser = $eventUser->getsfGuardUser() ?>
            <div class="group_member">
             <?php echo link_to(image_tag($cUser->getThumb(), 'alt=' . $cUser . ' title=' . $cUser . ' class=left'), '@user_profile?username=' . $cUser) ?>  
             <div class="group_member_title">
             <a href="<?php echo url_for('@user_profile?username='.$cUser)?>" > <?php echo mb_substr($cUser, 0, 9,'UTF-8').'<wbr>'.mb_substr($cUser, 9, strlen($cUser), 'UTF-8') ?></a>

           </div>
          <?php if($i==2){echo '</div><div class="members_line">';}?>
         <?php endforeach ?>
        </div>
      </div>
    <?php if($num_confirmed=count($event->getNoUsers())>6):?>
       <div class="see_all"><?php echo __('members').'('.$num_confirmed.')'?> <span style="float:right;"><?php echo link_to(__('see all'), '@event_allno?id='.$event->getId()) ?></span></div>
   <?php endif; ?>
  </div>
<?php endif ?>


<?php $invited = $event->getAwaitingReplyUsers($c)?>
<?php if (count($invited) > 0): ?>
  <div class="left_boxes">
    <div class="left_boxes_title"><?php echo __('Awaiting reply') ?></div>
         <div class="group_members">
        <div class="members_line">
         <?php foreach ($invited as $i=>$eventUser): ?>
             <?php $_user = $eventUser->getsfGuardUserRelatedByUserId() ?>
            <div class="group_member">
              <?php echo link_to(image_tag($_user->getThumb(), 'alt=' . $_user . ' title=' . $_user . ' class=left'), '@user_profile?username=' . $_user ) ?>
             <div class="group_member_title">
              <a href="<?php echo url_for('@user_profile?username='.$_user)?>" > <?php echo mb_substr($_user, 0, 9,'UTF-8').'<wbr>'.mb_substr($_user, 9, strlen($_user), 'UTF-8') ?></a>
            </div>
           </div>
          <?php if($i==2){echo '</div><div class="members_line">';}?>
         <?php endforeach ?>
        </div>
      </div>
    <?php if($num_confirmed=count($event->getAwaitingReplyUsers())>6):?>
       <div class="see_all"><?php echo __('members').'('.$num_confirmed.')'?> <span style="float:right;"><?php echo link_to(__('see all'), '@event_allawaitingreply?id='.$event->getId()) ?></span></div>
   <?php endif; ?>
  </div>
<?php endif ?>
