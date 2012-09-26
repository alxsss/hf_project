<table>
<tbody>
<?php foreach ($videolist_list as $videolist): ?>
<tr>
    <td>
<input type="radio" value="<?php echo $videolist->getId()?>" id="videolist_id_<?php echo $videolist->getId()?>" name="videolist_id">
<?php // echo radiobutton_tag('videolist_id', $videolist->getId(),  false) ?>
</td>
     <td><?php echo link_to($videolist->getName(), 'editvideolist/show?videolist_id='.$videolist->getId()) ?></td>    
     <td><?php echo link_to(image_tag('edit.png', 'alt=edit title=edit'), 'videolist/edit?id='.$videolist->getId()) ?></td>
	  <td><?php echo link_to(image_tag('delete.png', 'alt=delete title=delete'), 'videolist/delete?id='.$videolist->getId(), 'post=true&confirm=Are you sure?') ?></td>
  </tr>
<?php endforeach; ?>
</tbody>
</table>
