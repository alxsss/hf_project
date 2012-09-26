<?php use_helper('Javascript', 'I18N', 'Form') ?>

<div id="edit_<?php echo $count ?>">
      <?php echo form_tag('playlist/rename', 'name=sf_asset_rename_form') ?>
        <?php //echo input_hidden_tag('current_path', $current_path) ?>
        <?php echo input_hidden_tag('name', $playlist->getName()) ?>
        <?php echo input_hidden_tag('id', $playlist->getId()) ?>
        <?php echo input_hidden_tag('count', $count) ?>
        <?php echo input_tag('new_name', $playlist->getName()) ?>
        <?php echo submit_to_remote('rename', __('Rename', array(), 'playlist'), array(
          'url'      => 'playlist/rename',
          'update'   => 'block_'.$count,
          'script'   => true,
          'before'   => visual_effect('opacity', 'block_'.$count, array('duration' => '0.5', 'from' => '1.0', 'to' => '0.3')),
          'complete' => visual_effect('opacity', 'block_'.$count, array('duration' => '0.5', 'from' => '0.3', 'to' => '1.0')),
          ),'class=sf_asset_action_rename')?>
          <?php echo button_to_function(__('Cancel', array(), 'playlist'), "Element.hide('edit_".$count."');Element.show('view_".$count."')") ?>
      </form>
    </div>
