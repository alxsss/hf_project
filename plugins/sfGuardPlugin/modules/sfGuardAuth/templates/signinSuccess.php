<?php use_helper('I18N') ?>
<form action="<?php echo url_for('@login') ?>" method="post" >
  <table class="sigin_page">
    <?php echo $form ?>
	<tr><td colspan="2"> <?php echo link_to(__('Forgot your password?'), '@resetRequest') ?></td></tr>
	<tr><td colspan="2"><input type="submit" value="<?php echo __('sign in')?>" /></td></tr>
  </table>
</form>
<div class="registration_login">
  <span class="forgot_password"><?php echo __('You are not registered yet?')?></span><br>
   <?php echo link_to(__('Register'), '@register')?>
</div>  