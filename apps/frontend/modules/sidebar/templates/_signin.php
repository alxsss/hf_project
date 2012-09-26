  <div id="login" class="toggle_login">
   <h4><?php echo __('Please sign in first')?></h4>
    <span class="forgot_password"><span class="toggle_to_login"><a href="#"><?php echo __('cancel')?></a></span></span>
	<form action="<?php echo url_for('@login')?>" method="post" id="loginform">     
      <div class="loginbox"><div class="loginbox_account"><?php echo __('Username')?>:</div><input id="signin_username" name="signin[username]" type="text"/></div>
      <div class="loginbox"><div class="loginbox_account"><?php echo __('Password')?>:</div><input id="signin_password" name="signin[password]" type="password"/></div>
      <?php //echo input_hidden_tag('referer', $sf_params->get('referer') ? $sf_params->get('referer') : $sf_request->getUri()) ?>
      <input type="submit" value="<?php echo __('sign in')?>" >  <span class="forgot_password"><?php echo link_to(__('Forgot your password?'), '@resetRequest') ?></span>
    </form>	
  </div>
