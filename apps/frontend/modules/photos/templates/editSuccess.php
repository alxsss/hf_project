<?php use_helper('I18N') ?>
<div id="updates_left_column">
  <?php include_component('friends', 'ulinks')?>
</div>
<div id="right_column_user">
 <div class="edit_left_column">
  <div id="edit_photo">
  <a href="#" class="create_album"><?php echo __('Create new album')?></a>
  <div id="new_album" style="display: none">
    <form method="post" action="<?php echo url_for('photos/addalbum')?>">
     <?php include_partial('albums/create', array('form' => $albumForm)) ?>
     <a href="#" class="hide_create_album"><?php echo __('cancel')?></a>
    <input type="submit" id="create_album_button" value="<?php echo __('Create')?>">
  </form>
 </div>

<?php $photo = $form->getObject() ?>

<form action="<?php echo url_for('photos/update'.(!$photo->isNew() ? '?id='.$photo->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <table id="photo_upload">
    <tfoot>
      <tr>
        <td colspan="2">
		  <?php if ($photo->getAlbumId()): ?>
            &nbsp;<a href="<?php echo url_for('albums/show?id='.$photo->getAlbumId()) ?>"><?php echo __('Cancel')?></a>
		  <?php else: ?>
		    &nbsp;<a href="<?php echo url_for('photos/show?id='.$photo->getId()) ?>"><?php echo __('Cancel')?></a>
		  <?php endif; ?>
          <?php if (!$photo->isNew()): ?>
            &nbsp;<?php echo link_to(__('Delete'), 'photos/delete?id='.$photo->getId(), array('post' => true, 'confirm' => __('Are you sure?'))) ?>
          <?php endif; ?>
          <input type="submit" value="<?php echo __('Save')?>" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><label for="photo_album_id"><?php echo __('album name')?></label></th>
        <td>
		  <div id="photo_edit">
          <?php echo $form['album_id']->renderError() ?>
          <?php echo $form['album_id'] ?>
		  </div>
        </td>
      </tr>
	  <tr>
        <th></th>
        <td>
          <?php echo $form['user_id']->renderError() ?>
          <?php echo $form['user_id'] ?>
        </td>
      </tr>
      <tr>
        <th></th>
        <td>
          <?php //echo $form['filename']->renderError() ?>
          <?php //echo $form['filename'] ?>
		  <?php echo link_to(image_tag('/uploads/assets/photos/thumbnails/'.$photo->getFilename(), 'alt=no img'), 'photos/show?id='.$photo->getId()); ?>
        </td>
      </tr>      
      <tr>
        <th><label for="photo_title"><?php echo __('title')?></label></th>
        <td>
          <?php echo $form['title']->renderError() ?>
          <?php echo $form['title'] ?>
        </td>
      </tr>      
      <tr>
        <th><label for="photo_visibility"><?php echo __('visibility')?></label></th>
        <td>
          <?php echo $form['visibility']->renderError() ?>
          <?php echo $form['visibility'] ?>
        </td>
      </tr>
	   <tr>
        <th> <?php echo $form['popular_photo']->renderLabel() ?></th>
        <td>
          <?php echo $form['popular_photo']->renderError() ?>
          <?php echo $form['popular_photo'] ?>
        </td>
      </tr>      
      <tr>
        <th></th>
        <td>
          <?php //echo $form['photo_vote_list']->renderError() ?>
          <?php //echo $form['photo_vote_list'] ?>

        <?php echo $form['id'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
</div>
 </div><!-- end edit_left_column--> 
<?php include_partial('photos/ad_right_rectangle')?>
</div>
