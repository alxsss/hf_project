<?php use_helper('Text', 'I18N') ?>
<div id="updates_left_column">
  <?php if($sf_user->isAuthenticated()):?> 
    <?php include_component('friends', 'ulinks')?>
  <?php else:?>
    <?php include_partial('home/inhemsinif')?>	    
  <?php endif;?>
</div>
<div id="right_column_user">
<div class="edit_left_column">
<h2><?php echo __('Groups') ?></h2>

<?php if ($sf_user->hasFlash('notice')): ?>
<div class="notice">
  <?php echo __($sf_user->getFlash('notice')) ?>
</div>
<?php endif ?>
<div class="region_names">
  <?php foreach ($pager->getResults() as $group): ?>
    <strong><?php echo link_to($group->getTitle(), '@sf_social_group?id=' . $group->getId()) ?></strong>
    <div class="descr">
      <?php echo truncate_text($group->getDescription(), 50)?>
    </div>
  <?php endforeach ?>
</div>
</div>
<?php include_partial('photos/ad_right_rectangle')?>
  
<?php if ($pager->haveToPaginate()): ?>
    <?php foreach ($pager->getLinks() as $page): ?>
      <?php echo link_to_unless($page == $pager->getPage(), $page, '@sf_social_group_list?page=' . $page) ?>
    <?php endforeach ?>
  <?php endif ?>
<div style="clear:both;padding:10px;">
  <?php //echo link_to(__('your groups', null, 'sfSocial'), '@sf_social_group_mylist') ?> 
  <?php echo link_to(__('create a new group'), '@sf_social_group_new') ?>
</div>
</div>
