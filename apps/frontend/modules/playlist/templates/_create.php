<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>
  <table>
    <tbody>
	<?php echo $form->renderHiddenFields() ?>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['name']->renderLabel() ?></th>
        <td>
          <?php echo $form['name']->renderError() ?>
          <?php echo $form['name'] ?>
        </td>
	 </tr>
    </tbody>
  </table>