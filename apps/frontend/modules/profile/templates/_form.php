<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>
<?php use_helper('I18N') ?>

<form action="<?php echo url_for('profile/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="POST" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="PUT" />
<?php endif; ?>
  <table id="user_profile">
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          &nbsp;<a href="<?php echo url_for('user/'.$form->getObject()->getSfGuardUser()) ?>"><?php echo __('Cancel')?></a>
          <?php if (!$form->getObject()->isNew()): ?>
		  
            &nbsp;<?php echo link_to(__('Delete profile'), 'sfGuardUser/delete?id='.$form->getObject()->getSfGuardUser()->getId(), array('method' => 'delete', 'confirm' => __('Are you sure?'))) ?>

			<?php //echo link_to('Delete', 'profile/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="<?php echo __('Save')?>" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php //echo $form['user_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['user_id']->renderError() ?>
          <?php echo $form['user_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['first_name']->renderLabel() ?></th>
        <td>
          <?php echo $form['first_name']->renderError() ?>
          <?php echo $form['first_name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['last_name']->renderLabel() ?></th>
        <td>
          <?php echo $form['last_name']->renderError() ?>
          <?php echo $form['last_name'] ?>
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
        <th><?php echo $form['photo']->renderLabel() ?></th>
        <td>
          <?php echo $form['photo'] ?>
          <?php echo $form['photo']->renderError() ?>
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
        <th><?php echo $form['status']->renderLabel() ?></th>
        <td>
          <?php echo $form['status']->renderError() ?>
          <?php echo $form['status'] ?>
        </td>
      </tr>
	  <tr>
        <th><?php echo $form['visibility']->renderLabel() ?></th>
        <td>
          <?php echo $form['visibility']->renderError() ?>
          <?php echo $form['visibility'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['lookingfor']->renderLabel() ?></th>
        <td>
          <?php echo $form['lookingfor']->renderError() ?>
          <?php echo $form['lookingfor'] ?>
        </td>
      </tr>
      
      <tr>
        <th><?php echo $form['city']->renderLabel() ?></th>
        <td>
          <?php echo $form['city']->renderError() ?>
          <?php echo $form['city'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['state']->renderLabel() ?></th>
        <td>
          <?php echo $form['state']->renderError() ?>
          <?php echo $form['state'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['zip']->renderLabel() ?></th>
        <td>
          <?php echo $form['zip']->renderError() ?>
          <?php echo $form['zip'] ?>
        </td>
      </tr>	  
      <tr>
        <th><?php echo $form['country_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['country_id']->renderError() ?>
          <?php echo $form['country_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['website']->renderLabel() ?></th>
        <td>
          <?php echo $form['website']->renderError() ?>
          <?php echo $form['website'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['activities']->renderLabel() ?></th>
        <td>
          <?php echo $form['activities']->renderError() ?>
          <?php echo $form['activities'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['books']->renderLabel() ?></th>
        <td>
          <?php echo $form['books']->renderError() ?>
          <?php echo $form['books'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['music']->renderLabel() ?></th>
        <td>
          <?php echo $form['music']->renderError() ?>
          <?php echo $form['music'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['movies']->renderLabel() ?></th>
        <td>
          <?php echo $form['movies']->renderError() ?>
          <?php echo $form['movies'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['tvshows']->renderLabel() ?></th>
        <td>
          <?php echo $form['tvshows']->renderError() ?>
          <?php echo $form['tvshows'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['aboutme']->renderLabel() ?></th>
        <td>
          <?php echo $form['aboutme']->renderError() ?>
          <?php echo $form['aboutme'] ?>
        </td>
      </tr>      
    </tbody>
  </table>
</form>
