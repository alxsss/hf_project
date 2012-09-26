<?php //include_partial('sidebar/default') ?>
 
<h2>Video tags</h2>
 
<ul id="videos_tags">
  <?php include_partial('tag/tags', array('videos' => $videos, 'tags' => $videos->getTags())) ?> 
</ul>
<?php if ($sf_user->isAuthenticated()): ?>
  <div>Add your own:
    <?php echo form_remote_tag(array(
      'url'    => '@tag_add_video',
      'update' => 'videos_tags',
    )) ?>
      <?php echo input_hidden_tag('videos_id', $videos->getId()) ?>
      <?php echo input_auto_complete_tag('tag', '', 'tag/autocompleteVideo', 'autocomplete=off', 'use_style=true') ?>
      <?php echo submit_tag('Tag') ?>
    </form>
  </div>
<?php endif; ?>