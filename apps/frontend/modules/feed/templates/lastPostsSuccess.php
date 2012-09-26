<?php use_helper('Date') ?>

<h2>Latests posts from the mailing-list</h2>
<ul>
  <?php foreach($feed->getItems() as $post): ?>
  <li>
    <?php echo format_date($post->getPubDate(), 'd/MM H:mm') ?> -
    <?php echo link_to($post->getTitle(), $post->getLink()) ?>
	<?php //echo link_to($post->getQuery(), $post->getLink()) ?>
    by <?php echo $post->getAuthorName() ?>
  </li>
  <?php endforeach; ?>
</ul>
