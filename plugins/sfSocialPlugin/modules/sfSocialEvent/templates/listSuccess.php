<?php use_helper('I18N', 'Date') ?>
<div id="updates_left_column">
  <?php if($sf_user->isAuthenticated()):?>
    <?php include_component('friends', 'ulinks')?>
  <?php else:?>
    <?php include_partial('home/inhemsinif')?>
  <?php endif;?>
</div>
<div id="right_column_user">
<div class="edit_left_column">
<h2><?php echo __('events') ?></h2>
<?php if($sf_user->hasFlash('notice')): ?>
<div class="notice">
  <?php echo __($sf_user->getFlash('notice')) ?>
</div>
<?php endif ?>
<div class="region_names">
<?php foreach ($pager->getResults() as $event): ?>
    <strong><?php echo link_to($event->getTitle(), '@sf_social_event?id=' . $event->getId()) ?></strong>
    <div>
      <?php echo $event->getWhen() ?>
      <?php echo __('in %location%', array('%location%'=> $event->getLocation())) ?>
      - <?php echo __('organizer %user%', array('%user%'=>link_to($event->getsfGuardUser(), '@user_profile?username='.$event->getsfGuardUser()))) ?>
    </div>
<?php endforeach ?>
</div>
</div>
<?php include_partial('photos/ad_right_rectangle')?>
<?php if ($pager->haveToPaginate()): ?>
  <?php foreach ($pager->getLinks() as $page): ?>
    <?php echo link_to_unless($page == $pager->getPage(), $page, '@sf_social_event_list?page=' . $page) ?>
  <?php endforeach ?>
<?php endif; ?>
<div style="clear:both;padding:10px;">
  <?php echo link_to(__('create a new event'), '@sf_social_event_new') ?>
</div>
</div>
