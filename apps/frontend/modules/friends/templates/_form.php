<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form action="<?php echo url_for('friends/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="POST" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="PUT" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          &nbsp;<a href="<?php echo url_for('@updates') ?>"><?php echo __('Cancel')?></a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to(__('Delete'), 'friends/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="<?php echo __('Yes')?>" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php //echo $form['user_id']->renderLabel() ?></th>
        <td>
          <?php //echo $form['user_id']->renderError() ?>
          <?php //echo $form['user_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php //echo $form['friend_id']->renderLabel() ?></th>
        <td>
          <?php //echo $form['friend_id']->renderError() ?>
          <?php //echo $form['friend_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php //echo $form['approved']->renderLabel() ?></th>
        <td>
          <?php //echo $form['approved']->renderError() ?>
          <?php //echo $form['approved'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
