<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>
<?php use_helper('Object')?>
<form action="<?php echo url_for('music/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="POST" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="PUT" />
<?php endif; ?>
  <table id="photo_upload">
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          &nbsp;<?php echo link_to(image_tag('list.png', 'alt=list title=list'), 'playlist/list') ?>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;
		    <?php echo link_to(image_tag('delete.png', 'alt=delete title=delete'), 'music/delete?id='.$form->getObject()->getId(), 'post=true&confirm=Are you sure?') ?>
			<?php //echo link_to('Delete', 'music/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th>Playlists<?php //echo $form['playlist_id']->renderLabel() ?></th>
        <td>
		 <div id="playlist_list">
          <?php //echo $form['playlist_id']->renderError() ?>
          <?php $playlists=$form->getObject()->getPlaylistMusics() ?>
		  <?php echo select_tag('playlist_list', objects_for_select($playlist_list, 'getId', 'getName',
		  (!empty($playlists) ?$playlists[0]->getPlaylistId() : '')
		   ))?>
		  </div>
        </td>
      </tr>
     
      <tr>
        <th><?php echo $form['title']->renderLabel() ?></th>
        <td>
          <?php echo $form['title']->renderError() ?>
          <?php echo $form['title'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['artist']->renderLabel() ?></th>
        <td>
          <?php echo $form['artist']->renderError() ?>
          <?php echo $form['artist'] ?>
        </td>
      </tr>
      
      
      
      <tr>
        <th><?php echo $form['visibility']->renderLabel() ?>		
		</th>
        <td>
          <?php echo $form['visibility']->renderError() ?>
          <?php echo $form['visibility'] ?>
		  <?php echo $form['visibility']->renderHelp() ?>
        </td>
		
      </tr>
    </tbody>
  </table>
</form>
