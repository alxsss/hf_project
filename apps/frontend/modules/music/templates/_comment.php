<?php use_helper('Date') ?>

<div class="vote_block" id="vote_<?php //echo $answer->getId() ?>">
  <?php //echo include_partial('answer/vote_user', array('answer' => $answer, 'user'=>$answer->getUser())) ?>
</div>
 <?php foreach ($videos->getVideoComments() as $comment): ?>
  <div class="comment">
   <?php //echo $comment->getUser() ?>
     <?php echo format_date($comment->getCreatedAt(), 'p') ?>
  </div>
   <?php //echo $comment->getHtmlBody() ?>
   <?php echo $comment->getBody() ?>
   <?php endforeach; ?>