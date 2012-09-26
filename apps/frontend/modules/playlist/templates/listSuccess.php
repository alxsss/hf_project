<?php use_helper('Javascript', 'Form', 'I18N') ?>

<?php if(isset($song_url)): ?>
  <h5>Select playlist</h5>
<?php else: ?>
  <h5>Your Playlists</h5>
<?php endif; ?>

<h5><?php echo link_to_function('Create new', visual_effect('blind_down', 'new_playlist', array('duration' => 0.5)));?></h5>
<div id="new_playlist" style="display: none">
<h5><?php echo link_to_function('cancel', visual_effect('blind_up', 'new_playlist', array('duration' => 0.5))) ?></h5>
<?php echo form_remote_tag(array(
    'update'   => 'playlist_list',
    'url'      => 'playlist/addplaylist',
	'complete' => visual_effect('blind_up', 'new_playlist', array('duration' => 1)),
)) ?>
  <?php echo input_hidden_tag('song_url', $song_url) ?>
  <?php echo input_hidden_tag('song_title', $song_title) ?>
  <?php echo input_hidden_tag('artist', $artist) ?> 
 <?php include_partial('create', array('form' => $form)) ?>
  <?php echo submit_tag('Create' ) ?>
</form>
 </div>


<?php //added for new functionality, when music can be added from a playlist and a search results?>
<?php if(isset($song_url)||isset($music_id)): ?>
<?php echo form_tag('editPlaylist/update') ?>
  <?php echo input_hidden_tag('song_url', $song_url) ?>
  <?php echo input_hidden_tag('song_title', $song_title) ?>
  <?php echo input_hidden_tag('artist', $artist) ?>
  <?php echo input_hidden_tag('music_id', $music_id) ?> 
<?php endif; ?>
<div >
<table id="playlist_list">
<tbody>
<?php foreach ($playlist_list as $playlist): ?>

<tr>
<?php if(isset($song_url)||isset($music_id)): ?>
    <td class="playlist_list_radio_button"><?php echo radiobutton_tag('playlist_id', $playlist->getId(),  false) ?></td>
<?php endif; ?>
     <td><?php echo link_to($playlist->getName(), 'editPlaylist/show?playlist_id='.$playlist->getId()) ?></td>
     <td><?php echo link_to(image_tag('edit.png', 'alt=edit title=edit'), 'playlist/edit?id='.$playlist->getId().'&token='.$playlist->getSfGuardUser()->getSalt()) ?> </td>
	  <td><?php echo link_to(image_tag('delete.png', 'alt=delete title=delete'), 'playlist/delete?id='.$playlist->getId(), 'post=true&confirm=Are you sure?') ?></td>
  </tr> 
<?php endforeach; ?>
</tbody>
</table>
</div>

<br>
<?php if(isset($song_url)||isset($music_id)): ?>
  <?php echo submit_tag('add') ?>
<?php endif; ?>