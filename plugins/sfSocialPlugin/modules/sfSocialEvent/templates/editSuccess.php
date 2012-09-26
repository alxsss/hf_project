<?php use_helper('I18N')?>
<div id="left_column_user">
  <?php include_component('sfSocialEvent', 'elinks')?>
</div>
<div id="right_column_user">
<div class="edit_left_column">

<h2><?php echo __('Edit event &quot;%1%&quot;', array('%1%' => $event->getTitle())) ?></h2>

<form action="<?php echo url_for('@sf_social_event_edit?id=' . $event->getId()) ?>" method="post"  <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
   <table id="user_album">
    <?php echo $form ?>
    <tr class="buttons"><td colspan="2">
      <?php echo link_to(__('cancel'), '@sf_social_event?id=' . $event->getId(), 'class=cancel') ?>
      <?php echo link_to(__('Delete'), 'sfSocialEvent/delete?id='.$event->getId(), array('post' => true, 'confirm' => __('Are you sure?'))) ?>
      <input type="submit" value="<?php echo __('edit') ?>" />
    </td>
        </tr>
  </table>
</form>
</div>
<?php include_partial('photos/ad_right_rectangle')?>
</div>

