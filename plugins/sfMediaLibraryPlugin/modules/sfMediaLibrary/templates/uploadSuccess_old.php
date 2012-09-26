<?php use_helper('Javascript', 'I18N', 'Validation', 'Form') ?>
<div id="sf_asset_container">
  <h1><?php echo __('upload media') ?></h1>
  <div id="sf_asset_content">
    <div id="sf_asset_controls">
      <?php echo form_tag('sfMediaLibrary/upload', 'class=float-left id=sf_asset_upload_form name=sf_asset_upload_form multipart=true') ?>
      <?php //echo input_hidden_tag('current_dir', $currentDir) ?>
      <fieldset>
	  <?php //echo form_error('filename') ?>
        <div class="form-row">
          <?php echo label_for('file', __('Add a file:', array(), 'sfMediaLibrary'), '') ?>
          <div class="content"><?php echo input_file_tag('filename') ?></div>
        </div>
      </fieldset>
      <ul class="sf_asset_actions">
        <li><?php echo submit_tag(__('Add', array(), 'sfMediaLibrary'), array (
          'name'    => 'add',
          'class'   => 'sf_asset_action_add_file',
          //'onclick' => "if($('file').value=='') { alert('".__('Please choose a file first', array(), 'sfMediaLibrary')."');return false; }",
        )) ?></li>
      </ul>
      </form>
    </div>
    <div id="sf_asset_assets">
      <?php //include_partial('sfMediaLibrary/files', array('files' => $files, 'currentDir' => $currentDir, 'webAbsCurrentDir' => $webAbsCurrentDir, 'count' => count($dirs))) ?>
    </div>
  </div>
</div>