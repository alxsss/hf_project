<?php use_helper('Javascript') ?>

<h3>Edit Music</h3>

<h5><?php echo link_to_function('Create new playlist', visual_effect('blind_down', 'new_playlist', array('duration' => 0.5)));?></h5>
<div id="new_playlist" style="display: none">
  <h5><?php echo link_to_function('cancel', visual_effect('blind_up', 'new_playlist', array('duration' => 0.5))) ?></h5>
  <?php echo form_remote_tag(array(
    'update'   => 'playlist_list',
    'url'      => 'music/addplaylist',
	'complete' => visual_effect('blind_up', 'new_playlist', array('duration' => 1)),
  )) ?>
  
  
  <?php include_partial('playlist/create', array('form' => $playlistForm)) ?>
  <?php echo submit_tag('Create' ) ?>
</form>
</div>

<?php include_partial('form', array('form' => $form, 'playlist_list'=>$playlist_list)) ?>
