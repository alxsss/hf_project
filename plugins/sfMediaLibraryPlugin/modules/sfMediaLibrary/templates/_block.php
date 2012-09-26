<?php $action = $sf_context->getActionName() !== 'choice' ? 'index' : $sf_context->getActionName() ?>
<div class="thumbnails">
<?php $filedir=$info['filedir'];?>
    <?php $thumbnail = image_tag($info['icon'], array('alt' => $name, 'title' => $name, 'height' => '64')) ?>
    <?php echo link_to_function($thumbnail, "setFileSrc('".$web_abs_current_path.'/'.$filedir.'/'.$name."')") ?>
    <?php //$size = sprintf('&nbsp;&nbsp;[%d %s]', $info['size'] < 1000 ? $info['size'] : $info['size'] / 1000, $info['size'] < 1000 ? 'o' : 'Ko') ?>
    <?php $delete = 'delete' ?>
</div>
<div class="assetComment">
 <?php if ($action == 'index'): ?>
    <div style="text-align:right">
      <?php //echo $size ?>
      <?php echo link_to_remote(image_tag('/sfMediaLibraryPlugin/images/delete.png', array(
        'alt'   => __('Delete', array(), 'sfMediaLibrary'),
        'title' => __('Delete', array(), 'sfMediaLibrary'),
        'align' => 'absmiddle',
      )), 
	  array(
          'url'      => '@sfMediaLibrary_delete?name='.$name.'&filedir='.$filedir.'&id='.$id,
          'update'   => 'itemimgupload',
          'script'   => true,
          'before'   => visual_effect('opacity', 'block_'.$count, array('duration' => '0.5', 'from' => '1.0', 'to' => '0.3')),
          'complete' => visual_effect('opacity', 'block_'.$count, array('duration' => '0.5', 'from' => '0.3', 'to' => '1.0')),
          ),'class=sf_asset_action_rename')
	  
	  ?>
    </div>
  <?php endif; ?>
</div>

