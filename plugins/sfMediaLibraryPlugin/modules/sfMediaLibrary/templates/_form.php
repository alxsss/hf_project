<?php use_helper('Javascript', 'Object', 'I18N') ?>
<div id="sf_asset_container">
  <legend><?php echo __('upload a photo') ?></legend>
  <div id="sf_asset_content">
    <div id="sf_asset_controls">
<?php $uniqId = uniqid() ?>
    <form action="<?php echo url_for('@upload') ?>" method="POST" enctype="multipart/form-data"	class="float-left" id="sf_asset_upload_form" name="sf_asset_upload_form" >
    <fieldset>
	  <?php //echo $form->renderGlobalErrors() ?>
       <input id="progress_key" name="APC_UPLOAD_PROGRESS" type="hidden" value="<?php echo $uniqId ?>" />

        <div class="form-row">
		<?php //echo $form['filename']->renderLabel() ?>
          <?php //echo label_for('file', __('Add a file:', array(), 'sfMediaLibrary'), '') ?>
          <div class="content">
		  <?php echo $form['filename']->renderError() ?>
          <?php echo $form['filename'] ?>
		  <?php // echo input_file_tag('filename') ?>
		  </div>
        </div>
      </fieldset>
      <ul class="sf_asset_actions">
        <li>
		<?php //echo submit_tag(__('Add', array(), 'sfMediaLibrary'), array ('name'    => 'add', 'class'   => 'sf_asset_action_add_file',
          //'onclick' => "if($('file').value=='') { alert('".__('Please choose a file first', array(), 'sfMediaLibrary')."');return false; }", )) ?>
		<input type="submit" value="<?php echo __('Add')?>" class="sf_asset_action_add_file" />
		</li>
      </ul>
      <div id='progressbar' style='display: none'/> </div>
      </form>
    </div>
    
  </div>
</div>

