<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form action="<?php echo url_for('games/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          &nbsp;<a href="<?php echo url_for('games/index') ?>">Cancel</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'games/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['game_category_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['game_category_id']->renderError() ?>
          <?php echo $form['game_category_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['name']->renderLabel() ?></th>
        <td>
          <?php echo $form['name']->renderError() ?>
          <?php echo $form['name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['description']->renderLabel() ?></th>
        <td>
          <?php echo $form['description']->renderError() ?>
          <?php echo $form['description'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['embed_code']->renderLabel() ?></th>
        <td>
          <?php echo $form['embed_code']->renderError() ?>
          <?php echo $form['embed_code'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['thumb']->renderLabel() ?></th>
        <td>
          <?php echo $form['thumb']->renderError() ?>
          <?php echo $form['thumb'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['creative_screenshot']->renderLabel() ?></th>
        <td>
          <?php echo $form['creative_screenshot']->renderError() ?>
          <?php echo $form['creative_screenshot'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['created_at']->renderLabel() ?></th>
        <td>
          <?php echo $form['created_at']->renderError() ?>
          <?php echo $form['created_at'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['game_user_list']->renderLabel() ?></th>
        <td>
          <?php echo $form['game_user_list']->renderError() ?>
          <?php echo $form['game_user_list'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
