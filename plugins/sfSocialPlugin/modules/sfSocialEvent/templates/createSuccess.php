<?php use_helper('I18N')?>
<div id="updates_left_column">
<?php if($sf_user->isAuthenticated()):?>
   <?php include_component('friends', 'ulinks')?>
 <?php else:?>
  <?php include_partial('home/inhemsinif')?>
 <?php endif;?>
</div>
<div id="right_column_user">
<div class="edit_left_column">
  <h2><?php echo __('New event') ?></h2>
  <form action="<?php echo url_for('@sf_social_event_new') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <table id="user_album">
    <?php echo $form ?>
    <tr class="buttons"><td colspan="2">
      <?php echo link_to(__('cancel'), '@sf_social_event_list', 'class=cancel') ?>
      <input type="submit" value="<?php echo __('create') ?>" />
    </td></tr>
  </table>
</form>
</div>
<?php include_partial('photos/ad_right_rectangle')?>
</div>
