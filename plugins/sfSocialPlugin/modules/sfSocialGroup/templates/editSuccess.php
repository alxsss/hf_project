<?php use_helper('I18N')?>
<div id="left_column_user"> 
  <?php include_component('sfSocialGroup', 'glinks')?>
</div>
<div id="right_column_user">
<div class="edit_left_column">

<h2><?php echo __('Edit group &quot;%1%&quot;', array('%1%' => $group->getTitle())) ?></h2>

<form action="<?php echo url_for('@sf_social_group_edit?id=' . $group->getId()) ?>" method="post"  <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
   <table id="user_album">
    <?php echo $form ?>
    <tr class="buttons"><td colspan="2">
      <?php echo link_to(__('cancel'), '@sf_social_group?id=' . $group->getId(), 'class=cancel') ?>
      <?php echo link_to(__('Delete'), 'sfSocialGroup/delete?id='.$group->getId(), array('post' => true, 'confirm' => __('Are you sure?'))) ?>     
      <input type="submit" value="<?php echo __('edit') ?>" />
    </td>
	</tr>
  </table>
</form>
</div>
<?php include_partial('photos/ad_right_rectangle')?>
</div>
