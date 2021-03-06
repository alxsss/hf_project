<?php use_helper('Date', 'Text', 'I18N') ?>
<tr>
  <td class="forum_name">
    <?php echo link_to($forum->getName(), 'sfSimpleForum/forum?forum_name='.$forum->getStrippedName()) ?><br />
    <span class="forum_description"><?php echo simple_format_text($forum->getDescription()) ?></span>
  </td>
  <td class="forum_threads"><?php echo $forum->getNbTopics() ?></td>
  <td class="forum_posts"><?php echo $forum->getNbPosts() ?></td>
  <td class="forum_recent">
    <?php if ($forum->getLatestPostId()): ?>
      <?php $latest_post = $forum->getsfSimpleForumPost(); ?>
      <?php echo link_to($latest_post->getTitle(), 'sfSimpleForum/post?id='.$latest_post->getId()) ?><br />
      <?php echo __('%date% ago by %author%', array(
        '%date%'   => distance_of_time_in_words($latest_post->getCreatedAt('U')),
        '%author%' => link_to($latest_post->getAuthorName(), 'sfSimpleForum/userLatestPosts?username='.$latest_post->getAuthorName())
        )) ?>
    <?php endif ;?>
  </td>
</tr>
