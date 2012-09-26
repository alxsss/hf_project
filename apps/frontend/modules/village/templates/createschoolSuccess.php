<?php use_helper('sfSimpleForum', 'I18N') ?>
<?php slot('hemsinif_breadcrumb') ?>
<?php echo forum_breadcrumb(array(
    array('home', @homepage),
	array($village->getRegion()->getName(), 'region/show?id='.$village->getRegion()->getId()),
	$village->getName() 
  )) ?> 
<?php end_slot() ?> 
<div class="region_names">
  <?php foreach($schools as $school):?>
    <?php echo link_to($school->getName(), '@register?id='.$school->getId());?>
  <?php endforeach; ?>
</div>
<form action="<?php echo url_for('village/createschool?id='.$village_id)?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
   <table class="region_list">
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          <input type="submit" value="<?php echo __('Add')?>" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
	  	  <tr><td colspan="2"><?php echo __('If you do not see your school in the above list, you can add it here')?></td></tr>
      <tr>
        <th></th>
        <td>
          <?php echo $form['name']->renderError() ?>
		  <?php echo __('Add school')?><br>
          <?php echo $form['name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php //echo $form['region_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['village_id']->renderError() ?>
          <?php echo $form['village_id'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>