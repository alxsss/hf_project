<?php use_helper('Global') ?>
<h3><?php echo $subscriber?>'s playlists</h3>
<table id="playlist_list">
<tbody>
<?php foreach ($playlist_pager->getResults() as $playlist): ?>
<tr>
  <td><?php echo link_to($playlist->getName(), 'editPlaylist/show?playlist_id='.$playlist->getId()) ?></td>
  <?php if ($username_user_id==$user_id):?>
    <td><?php echo link_to(image_tag('edit.png', 'alt=edit title=edit'), 'playlist/edit?id='.$playlist->getId().'&token='.$playlist->getSfGuardUser()->getSalt()) ?> </td>
	<td><?php echo link_to(image_tag('delete.png', 'alt=delete title=delete'), 'playlist/delete?id='.$playlist->getId(), 'post=true&confirm=Are you sure?') ?></td>
  <?php endif;?>	
  </tr> 
<?php endforeach; ?>
</tbody>
</table>

<div class="pagination">
  <div id="photos_pager">
    <?php echo pager_navigation($playlist_pager, 'playlist/list') ?>
  </div>
</div>
