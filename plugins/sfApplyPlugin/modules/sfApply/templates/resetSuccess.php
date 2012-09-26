<?php use_helper('I18N') ?>
<div class="sf_apply sf_apply_reset">
<form method="POST" action="<?php echo url_for("sfApply/reset") ?>" name="sf_apply_reset_form" id="sf_apply_reset_form">
  <?php if(!$sf_user->isAuthenticated()):?> 
   <p>
     <?php echo __('You may now change your password using the form below.')?>
   </p>
  <?php endif;?>
  <table>
   <tr>
     <td><?php echo $form['password']->renderLabel() ?></td>
	 <td><?php echo $form['password']->renderError() ?>
	 	<?php echo $form['password'] ?></td>
   </tr>
    <tr><td><?php echo $form['password2']->renderLabel() ?></td>
	<td><?php echo $form['password2']->renderError() ?>
	 <?php echo $form['password2'] ?></td>
   </tr>
   <tr><td><?php echo $form['password_hint']->renderLabel() ?>
   </td>
   <td><?php echo $form['password_hint']->renderError() ?>
	<span class="password_hint_help"><?php echo __('a word that can help you to remember your password') ?></span><br>
	<?php echo $form['password_hint'] ?></td></tr>	
	<tr><td colspan="2"><input type="submit" value="<?php echo __("Reset") ?>">
      <?php echo link_to(__('Cancel'), 'sfApply/resetCancel') ?></td></tr>
    </table>
</form>
</div>