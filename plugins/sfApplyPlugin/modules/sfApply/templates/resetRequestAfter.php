<?php use_helper('I18N') ?>
<div class="sf_apply_notice">
<?php echo __('A confirmation email has been sent to the email address. You will need to click on a link provided in that email in order to change your password. If you do not see the message, be sure to check your "spam" and "bulk" email folders.') ?>
<p>
<?php echo link_to(__('Continue'), '@homepage') ?>
</p>
</div>