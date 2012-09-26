<?php use_helper('Javascript', 'Form') ?>
<table>
<tbody>
<?php foreach ($playlist_list as $playlist): ?>
<tr>
<?php if(isset($song_url)): ?>
    <td><?php echo radiobutton_tag('playlist_id', $playlist->getId(),  false) ?></td>
<?php endif; ?>
     <td><?php echo link_to($playlist->getName(), 'editPlaylist/show?playlist_id='.$playlist->getId()) ?></td>    
     <td><?php echo link_to(image_tag('edit.png', 'alt=edit title=edit'), 'playlist/edit?id='.$playlist->getId()) ?></td>
	  <td><?php echo link_to(image_tag('delete.png', 'alt=delete title=delete'), 'playlist/delete?id='.$playlist->getId(), 'post=true&confirm=Are you sure?') ?></td>
  </tr>
<?php endforeach; ?>
</tbody>
</table>