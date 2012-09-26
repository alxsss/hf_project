<?php use_helper('I18N') ?>
<div id="edit_profile">
  <h3><?php echo __('edit profile')?></h3>
  <?php include_partial('form', array('form' => $form)) ?>
  <form method="GET" action="<?php echo url_for("sfApply/resetRequest") ?>" name="sf_apply_reset_request" id="sf_apply_reset_request">
    <p>
      <?php echo __('Click the button below to change your password.') ?>
    </p>
    <input type="submit" value="<?php echo __('Reset Password') ?>" />
  </form>
</div>