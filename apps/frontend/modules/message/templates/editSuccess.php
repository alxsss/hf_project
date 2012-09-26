 <?php use_helper('Global', 'I18N') ?>
<?php include_partial('links') ?>
<div id="messages_inbox">
<?php $message = $form->getObject() ?>
<form action="<?php echo url_for('message/update'.(!$message->isNew() ? '?id='.$message->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <input type="hidden" name="<?php if(isset($to_userid)) echo 'to_userid' ;if(isset($id)) echo 'id';?>" value="<?php if(isset($to_userid)) echo $to_userid ;if(isset($id)) echo $id;// this is done in order to give this value to update function when validation fails?>" >
  <table  class="readMessage" width="100%" cellspacing="1" cellpadding="4" border="0">
    <tfoot>
      <tr>
        <td colspan="2">
          &nbsp;<a href="<?php echo url_for('@user_inbox') ?>"><?php echo __('Cancel')?></a>
          <?php if (!$message->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'message/delete?id='.$message->getId(), array('post' => true, 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="<?php echo __('Send')?>" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
	  <tr>
        <th><?php echo __('To')?></th>
        <td>
          <?php echo $form['to_userid']->renderError() ?>
          <?php echo $form['to_userid'] ?>
		  <?php echo $form['from_userid'] ?>
		  <?php $photo=$recepient->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
		  <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'style="clear:both; float:left " alt=no img'), 'user/'.$to_username) ?>
		  <span class="new_message_username"><?php echo link_to($to_username,'user/'.$to_username) ?></span>
        </td>
      </tr>
      <tr>
        <th><label for="message_subject"><?php echo __('Subject')?></label></th>
        <td>
          <?php echo $form['subject']->renderError() ?>
          <?php echo $form['subject'] ?>
        </td>
      </tr>           
      <tr>
        <th><label for="message_msgtext"><?php echo __('Message')?></label></th>
        <td>
          <?php echo $form['msgtext']->renderError() ?>
          <?php echo $form['msgtext'] ?>
          <?php echo $form['id'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
</div>