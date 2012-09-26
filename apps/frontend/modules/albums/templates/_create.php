<?php $album = $form->getObject() ?>

  <table id="user_album">
    
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><label for="album_title"><?php echo __('title')?></label></th>
        <td>
          <div class="error_message"><?php echo __('Required.')?></div><br>
          <?php echo $form['title']->renderError() ?>
          <?php echo $form['title'] ?>
        </td>
      </tr>
      <tr>
        <th><label for="album_description"><?php echo __('description')?></label></th>
        <td>
          <?php echo $form['description']->renderError() ?>
          <?php echo $form['description'] ?>
        </td>
      </tr>
      <tr>
        <th><label for="album_visibility"><?php echo __('visibility')?></label></th>
        <td>
          <?php echo $form['visibility']->renderError() ?>
          <?php echo $form['visibility'] ?>
        </td>
      </tr>
      <tr>
        <th></th>
        <td>
          <?php echo $form['user_id']->renderError() ?>
          <?php echo $form['user_id'] ?>

        <?php echo $form['id'] ?>
        </td>
      </tr>
    </tbody>
  </table>

