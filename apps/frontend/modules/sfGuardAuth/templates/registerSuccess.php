<?php use_helper('I18N', 'Date') ?>
<?php //use_helper('recaptcha') ?>
  <?php //echo $form ?>
  <div class="user_registerCol2">
   <?php if($school_id):?>
     <?php use_helper('sfSimpleForum') ?>
     <?php slot('hemsinif_breadcrumb') ?>
       <?php echo forum_breadcrumb(array(
       array(__('home'), @homepage),
	   array($school->getVillage()->getRegion()->getName(), 'region/show?id='.$school->getVillage()->getRegion()->getId()),
	   array($school->getVillage()->getName(), 'village/show?id='.$school->getVillage()->getId()),
	   $school->getName()
       )) ?> 
     <?php end_slot() ?> 
   <?php endif;?>
   
    <form action="<?php echo url_for('@register?id='.$school_id) ?>" method="post" class="user_register">
      <table border="0" class="register_form" cellpadding="0" cellspacing="0">
	  <tbody>
	  
	  <tr>
        <th><?php //echo $form['school_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['school_id']->renderError() ?>
          <?php echo $form['school_id'] ?>
        </td>
      </tr>
	  <?php if($user_id)://for the case when a registered user wants to add a school?>
	     <tr>
        <th><?php echo __($form['grad_year']->renderLabel()) ?></th>
        <td>
          <?php echo $form['grad_year']->renderError() ?>
          <?php echo $form['grad_year'] ?>
		  <?php echo $form['user_id'] ?>
        </td>
      </tr>
	  <tr>
		  <td></td>
		  <td><input type="submit" name="submit" value="<?php echo __('Add')?>" /></td>
		</tr>	
     <?php else:?>
	  
	  <?php if($school_id):?>
	  <tr>
        <th><label><?php //echo __('Registered users') ?></label></th>
        <td><?php //echo $school->countSchoolUsers()+1?></td>
      </tr>
	  <tr>
        <th><?php echo $form['grad_year']->renderLabel() ?></th>
        <td>
          <?php echo $form['grad_year']->renderError() ?>
          <?php echo $form['grad_year'] ?>
        </td>
      </tr>
     <?php endif;?>
	  <tr>
        <th><?php echo $form['username']->renderLabel() ?></th>
        <td>
          <?php echo $form['username']->renderError() ?>
          <?php echo $form['username'] ?>
        </td>
      </tr>
	  <tr>
        <th><?php echo $form['password']->renderLabel() ?></th>
        <td>
          <?php echo $form['password']->renderError() ?>
          <?php echo $form['password'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['password_again']->renderLabel() ?></th>
        <td>
          <?php echo $form['password_again']->renderError() ?>
          <?php echo $form['password_again'] ?>
        </td>
      </tr>

      <tr>
        <th><?php echo $form['email']->renderLabel() ?></th>
        <td>
          <?php echo $form['email']->renderError() ?>
          <?php echo $form['email'] ?>
        </td>
      </tr>
	  <tr>
        <th><?php echo $form['password_hint']->renderLabel() ?><br>
			<span class="password_hint_help"><?php echo __('is not required if you have an email') ?></span>
		</th>
        <td>
		 	<span class="password_hint_help"><?php echo __('a word that can help you to remember your password') ?></span><br>		  
		  <?php echo $form['password_hint']->renderError() ?>
          <?php echo $form['password_hint'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['birthday']->renderLabel() ?></th>
        <td>
          <?php echo $form['birthday']->renderError() ?>
          <?php echo $form['birthday'] ?>
        </td>
      </tr>
	  <tr>
        <th><?php echo $form['gender']->renderLabel() ?></th>
        <td>
          <?php echo $form['gender']->renderError() ?>
          <?php echo $form['gender'] ?>
        </td>
      </tr>
	   <tr>
        <th></th>
        <td>
          <?php echo $form['is_active'] ?>
        </td>
      </tr>
	    <tr>
		  <td></td>
		  <td><input type="submit" name="submit" value="<?php echo __('register')?>" /></td>
		</tr>	
	  <?php endif; //end of first if?>
		</tbody>
      </table>  
    </form>
  </div> 
