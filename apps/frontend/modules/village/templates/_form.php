<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form action="<?php echo url_for('village/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          &nbsp;<a href="<?php echo url_for('village/index') ?>">Cancel</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'village/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['name']->renderLabel() ?></th>
        <td>
          <?php echo $form['name']->renderError() ?>
          <?php echo $form['name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['region_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['region_id']->renderError() ?>
          <?php echo $form['region_id'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
