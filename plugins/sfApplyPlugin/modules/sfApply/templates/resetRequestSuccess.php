<?php use_helper('I18N') ?>
<div class="sf_apply sf_apply_reset_request">
<form method="POST" action="<?php echo url_for('sfApply/resetRequest') ?>"
  name="sf_apply_reset_request" "id" = "sf_apply_reset_request">
<p>
<?php echo __('Please enter your username and click "Reset." A link permitting you to change your password will then be sent to the email address associated with your username. If you do not have an email address then your password hint will be displayed.') ?>
</p>
<ul>
<?php echo $form ?>
<li>
<input type="submit" value="<?php echo __("Reset") ?>">
<?php echo link_to(__('Cancel'), '@homepage') ?>
</li>
</ul>
</form>
</div>
