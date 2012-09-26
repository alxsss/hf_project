<?php use_helper('I18N') ?>
<div class="sf_apply_notice">
<p>
<?php foreach($errors as $error): ?>
   <?php echo __($error).'<br>'; ?>
<?php endforeach; ?>   
  <?php echo link_to(__('Invite more friends'), '@invitefriend') ?>
</p>
</div>
