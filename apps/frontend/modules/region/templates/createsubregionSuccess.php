<?php use_helper('sfSimpleForum', 'I18N') ?>
<?php slot('hemsinif_breadcrumb') ?>
  <?php echo forum_breadcrumb(array(array('home', @homepage), $region->getName() )) ?>  
<?php end_slot() ?> 
<div class="region_names">
 <?php foreach($villages as $village):?>
  <?php echo link_to($village->getName(), 'village/show?id='.$village->getId());?>
  <br>
<?php endforeach; ?>
</div>
<form action="<?php echo url_for('region/createsubregion?id='.$region_id)?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
  	  <tr><td colspan="2"><?php echo __('If you do not see your region/village in the above list, you can add it here. If your school is not in a village, you can add it here in the schools link.')?></td></tr>
      <tr>
        <th></th>
        <td>
          <?php echo $form['name']->renderError() ?>
		  <?php echo __('Add region/village')?><br>
          <?php echo $form['name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php //echo $form['region_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['region_id']->renderError() ?>
          <?php echo $form['region_id'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>