<?php //include_partial('sidebar/default') ?>
<?php use_helper('Javascript') ?>
<div id="photo_tag"> 
  <div class="tag_title">Tags</div>  
 <div id="photos_tags"> 
    <?php include_partial('tag/tags', array('photos' => $photos, 'tags' => $photos->getTags(), 'user_id' => $user_id)) ?> 
 </div>
  <?php  // $photo_owner_id=$photos->getAlbum()->getUserId();?>
  <?php  $photo_owner_id=$photos->getUserId();?>
  <?php if($photo_owner_id==$user_id)://if ($sf_user->isAuthenticated()): ?>
    <?php echo form_remote_tag(array(
      'url'    => '@tag_add',
      'update' => 'photos_tags',
      )) ?>
      <?php echo input_hidden_tag('photos_id', $photos->getId()) ?>
      <?php //echo input_auto_complete_tag('tag', '', 'tag/autocomplete', 'autocomplete=off', 'use_style=true') ?>
	  <?php echo input_tag('tag', '', 'size=15') ?>
      <?php echo submit_tag('Add') ?>
    </form>
  <?php endif; ?>
</div>