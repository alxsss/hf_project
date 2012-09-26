<?php use_helper('I18N') ?>
<div class="home_signin_register">
<?php if(!$sf_user->isAuthenticated()):?> 
  <form action="<?php echo url_for('@login') ?>" method="post" >
    <table class="home_login">
	<tr>
     <th><?php echo $form['username']->renderLabel() ?></th>
	</tr>
	<tr><td><?php echo $form['username']->renderError() ?>
    <?php echo $form['username'] ?></td></tr>
    
	<tr>
     <th><?php echo $form['password']->renderLabel() ?></th>
	</tr>
	<tr><td>
    <?php echo $form['password']->renderError() ?>
    <?php echo $form['password'] ?></td></tr>
	<tr><td colspan="2"> <?php echo link_to('<span class="forgot_password">'.__('Forgot your password?').'</span>', '@resetRequest') ?></td></tr>
	<tr><td colspan="2"><input type="submit" value="<?php echo __('sign in')?>" /></td></tr>
  </table>
</form>
  <div class="registration">
    <?php echo link_to(__('Registration'), '@register')?>
  </div>
<?php endif;?> 
         <?php include_partial('home/inhemsinif')?>
</div>
<div id="right_column_user">
  <div class="graduated"><?php //echo __('I graduated school in')?> </div>
  <div class="choose_region"><?php echo __('Choose a region in order to find your school')?> </div>
   <?php include_partial('home/regions', array('regions'=>$regions))?>
 </div>
