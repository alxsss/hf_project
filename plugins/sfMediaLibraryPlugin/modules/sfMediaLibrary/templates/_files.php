<?php foreach ($files as $file => $info): $count++ ?>
  <div id="block_<?php echo $count ?>" class="assetImage">
    <?php include_partial('sfMediaLibrary/block', array(
      'name'                 => $file,   
      'web_abs_current_path' => $webAbsCurrentDir,
      'type'                 => 'file',
      'info'                 => $info,
      'count'                => $count,	
	  'id'                   =>$id,  
    )) ?>
  </div>
<?php endforeach; ?>