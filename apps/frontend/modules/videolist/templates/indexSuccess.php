<?php use_helper('I18N') ?>
<div class="ifp_nav">
  <ul>
   <li><?php echo link_to(__('recently featured'), 'videos/index')?></li>
   <li><?php echo link_to(__('most viewed'), 'videos/mostviewed')?></li>
  </ul>
</div>
<div class="edit_left_column">
  <div id="edit_photo">
    <a href="#" class="create_album"><?php echo __('Create new videolist')?></a>
    <div id="new_album" style="display: none">
      <form method="post" action="<?php echo url_for('videolist/addvideolist')?>">
        <?php include_partial('create', array('form' => $form)) ?>
        <a href="#" class="hide_create_album"><?php echo __('cancel')?></a>
        <input type="submit" id="create_album_button" value="<?php echo __('Create')?>">
      </form>
    </div>
   <div class="select_videolist">
     <?php if(isset($video_id)): ?>
      <h4><?php echo __('Select videolist')?></h4>
    <?php else: ?>
     <h4><?php echo __('Your Videolists')?></h4>
    <?php endif; ?>
   </div>
    <?php //added for new functionality, when music can be added from a videolist and a search results?>
    <?php if(isset($video_id)): ?>
      <form method="post" action="<?php echo url_for('editvideolist/update')?>">
        <input type="hidden" value="<?php echo $video_id?>" id="video_id" name="video_id">
    <?php endif; ?>
    <div id="photo_edit">
      <table id="videolist_list">
        <tbody>
          <?php foreach ($videolist_list as $videolist): ?>
            <tr class="items">
              <?php if(isset($video_id)): ?>
                 <td class="videolist_list_radio_button">
                   <input type="radio" value="<?php echo $videolist->getId()?>" id="videolist_id_<?php echo $videolist->getId()?>" name="videolist_id">
                 </td>
              <?php endif; ?>
              <td><?php echo link_to($videolist->getName(), 'editvideolist/show?videolist_id='.$videolist->getId()) ?></td>
              <td>
            <?php echo link_to(image_tag('edit.png', 'alt=edit title=edit'), 'videolist/edit?id='.$videolist->getId().'&token='.$videolist->getSfGuardUser()->getSalt()) ?> </td>
             <td><div class="delete_item">
                <a href="<?php echo url_for('videolist/delete?id='.$videolist->getId())?>"> <?php echo image_tag('delete.png', 'alt=delete title=delete')?></a>
              </div>
<?php //echo link_to(image_tag('delete.png', 'alt=delete title=delete'), 'videolist/delete?id='.$videolist->getId(), 'post=true&confirm=Are you sure?') ?></td>
           </tr> 
         <?php endforeach; ?>
       </tbody>
      </table>
    </div>
    <?php if(isset($video_id)): ?>
      <input type="submit" value="<?php echo __('Add')?>" name="commit"> 
    <?php endif; ?>
  </div>
</div><!-- end edit_left_column-->
<?php include_partial('videos/ads')?>

