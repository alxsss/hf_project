<?php use_helper('Date', 'Global', 'Form', 'Javascript') ?>

<div class="vote_block" id="vote_<?php //echo $answer->getId() ?>">
  <?php //echo include_partial('answer/vote_user', array('answer' => $answer, 'user'=>$answer->getUser())) ?>
</div>
<?php foreach ($playlist->getPlaylistCommentsJoinsfGuardUser() as $comment): ?>
  <div class="comments">
    <?php $photo=$comment->getsfGuardUser()->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
    <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'style="float:left; margin-right:5px;" alt=alt=no img'), 'user/'.$comment->getsfGuardUser()->getUsername()) ?>
	<?php echo link_to($comment->getsfGuardUser()->getUsername(), 'user/'.$comment->getsfGuardUser()->getUsername()) ?> (<?php echo format_date($comment->getCreatedAt(), 'p') ?>)<br><br>   
    <?php //echo $comment->getHtmlBody() ?>
    <?php echo $comment->getBody() ?>
  </div>
<?php endforeach; ?>

<?php echo use_helper('User') ?>
<div class="comment">
  <?php if ($sf_user->isAuthenticated()): ?>
  <?php //echo $sf_user->getUsername() ?>
  <?php //$sf_user->getAttribute('username', '', 'subscriber');  ?>
 

  <?php echo form_remote_tag(array(
    'url'      => '@add_comment_playlist',
    'update'   => array('success' => 'add_comment'),
    'loading'  => "Element.show('indicator')",
    'complete' => "Element.hide('indicator');".visual_effect('highlight', 'add_comment'),
  )) ?>
   <label for="label">Your comment:</label>
 <fieldset class="user_comment">      
    <?php echo textarea_tag('body', $sf_params->get('body'), 'size=40x3  class=textarea') ?>
 </fieldset>
    <div class="submit-row">
      <?php echo input_hidden_tag('playlist_id', $playlist->getId()) ?>
      <?php echo submit_tag('submit') ?>
    </div>
  </form>

<?php else: ?>
  <?php echo 'You must '.link_to_login('sign in').' to submit a comment' ?>
<?php endif; ?>
</div>