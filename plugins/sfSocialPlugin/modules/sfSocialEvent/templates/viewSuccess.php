<?php use_helper('I18N', 'Status',  'Date', 'Global') ?>
<div id="left_column_user">
  <?php //if($sf_user->isAuthenticated()):?>
    <?php include_component('sfSocialEvent', 'elinks')?>
  <?php //else:?>
  <?php //include_partial('home/inhemsinif')?>
<?php //endif;?>
</div>
<div id="right_column_user">
  <?php include_partial('sidebar/signin')?>
  <?php if(($event->getVisibility())&&!($event->isInvited($user_id)||$event->isAdmin($user_id)) ):?>
    <div class="private_profile">
      <?php echo __('This event is set to private')?>
    </div>
    <?php include_partial('friends/horizontal_ad')?>
  <?php else:?>
    <div id="updates_status_right_column">
      <div class="group_title_description">
        <h3><?php echo __('Event &quot;%1%&quot;', array('%1%' => $event->getTitle())) ?></h3>
        <?php if ($sf_user->hasFlash('notice')): ?>
          <div class="notice">
            <?php if ($sf_user->hasFlash('nr')): ?>
              <?php echo __($sf_user->getFlash('notice'), array('%1%' => $sf_user->getFlash('nr'))) ?>
           <?php else: ?>
             <?php echo __($sf_user->getFlash('notice')) ?>
           <?php endif;?>
          </div>
        <?php endif ?>
        <?php if($sf_user->isAuthenticated()):?>
          <div id="event_confirm">
            <form action="<?php echo url_for('@sf_social_event?id=' . $event->getId()) ?>" method="post">
              <?php echo $form['confirm']->renderError() ?>
              <?php echo $form['confirm']->renderLabel() ?>
              <?php echo $form['confirm'] ?>
              <input type="submit" value="<?php echo __('confirm') ?>" />
              <?php echo $form->renderHiddenFields() ?>
            </form>
          </div>
        <?php endif; ?>
        <table id="user_profile">
          <tr>
            <th><?php echo __('When') ?></th>
            <td><?php echo $event->getWhen() ?></td>
          </tr>
          <tr>
            <th><?php echo __('Location') ?></th>
            <td><?php echo $event->getLocation() ?></td>
          </tr>
          <tr>
            <th><?php echo __('Organizer') ?></th>
            <td><?php echo link_to($event->getsfGuardUser(), '@user_profile?username='.$event->getsfGuardUser());//getUserAdmin() returns only id not username ?></td>
          </tr>
          <tr>
            <th><?php echo __('Description') ?></th>
            <td><?php echo $event->getDescription() ?></td>
          </tr>
        </table>
	  </div>
        <?php if($sf_user->isAuthenticated()):?>
          <div id="status_box">
            <form id="user_status_form" action="<?php echo url_for('@event_status?id='.$event->getId())?>" method="post">
              <input type="text" id="user_status_box" name="user_status_box" class="defaultText cleardefault" title="<?php echo __('What do you think?')?>" size="50"  value="<?php echo __('What do you think?')?>">
              <span class="submit-row">
                <input type="submit" value="<?php echo __('Submit')?>" id="user_status_button">
              </span>
            </form>
         </div>
        <?php endif;?>
<div class="group_comments">
<div class="user_status_element_new"></div>
<?php foreach($event_status_pager->getResults() as $status):?>
 <?php $user=sfGuardUserPeer::retrieveByPk($status->getUserId()); $photo=$user->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
  <div class="user_status">
    <div class="user_status_photo">
      <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'alt=alt=no img class=border_image'), '@user_profile?username='.$user->getUsername()) ?>
    </div>
    <div  class="status_text">
      <span class="update_username"><?php echo link_to($user->getUsername(), '@user_profile?username='.$user->getUsername()) ?></span>:<?php echo $status->getStatus()?>
          <div class="comment_actions">
            <div class="updates_action">
            (<?php echo status_date($status->getCreatedAt('U'), format_date($status->getCreatedAt(), 'p'))?>)
                 <a href="#" class="comment_status"><?php echo __('comment')?></a>
            </div>
            <div class="add_status_comment">
              <?php include_partial('event_status_comment', array('user_id'=>$user_id, 'status_id'=>$status->getId())) ?>
              <div class="user_status_comment_new"></div>
            </div>
            <div class="status_comment_box">
               <?php if ($sf_user->isAuthenticated()): ?>
                 <form action="<?php echo url_for('@add_event_status_comment')?>" method="post">
                   <input type="hidden" value="<?php echo $status->getId()?>"  name="item_id">
                   <input type="hidden" value="<?php echo $status->getEventId()?>"  name="item_user_id">
                   <input type="hidden" value="1"  name="page">
                   <textarea cols="30" rows="3" class="expand24 status_box" id="comment" name="comment"></textarea>
                   <div class="submit-row">
                     <input type="submit" value="<?php echo __('comment')?>" class="status_comment_box_form">
                   </div>
                  </form>
                <?php else: ?>
                  <div class="comment">
                    <?php echo __('You must ')?><span class="toggle_to_login"><a href="#"><?php echo __('sign in')?></a><?php echo __(' to submit a comment') ?></span>
                  </div>
                <?php endif;//endif of comment ?>
            </div>

          </div>
        </div>
        <?php if($event->isAdmin($user_id)):?>
      <span class="delete_status">
            <a href="#" status_id="<?php echo $status->getId()?>" action="<?php echo url_for('@delete_event_status')?>"><?php echo __('Delete')?></a>
      </span>
        <?php endif;?>
  </div>
<?php endforeach;?>
</div>
<?php if($event_status_pager->haveToPaginate()):?>
    <div class="pagination">
      <div id="photos_pager">
        <?php echo pager_navigation($event_status_pager, '@sf_social_event?id='.$event->getId()) ?>
      </div>
    </div>
  <?php endif;?>
</div>
<div id="friend_suggestions">
  <?php include_partial('friends/ad200x200')?>
</div>

<?php endif;//visibility ?>
</div>

