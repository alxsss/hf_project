<?php if(sfConfig::get('app_sfSimpleForumPlugin_use_feeds', true)): ?>
  <?php slot('auto_discovery_link_tag') ?>
    <?php echo auto_discovery_link_tag('rss', $feed_rule, array('title' => $feed_title)) ?>
  <?php end_slot() ?>
<?php endif; ?>

<div class="forum_figures">
  <?php if($nb_topics<2):?>
    <?php echo link_to_if(
    $display_topic_link,
    __(format_number_choice('[0]No topic yet|[1]One topic|(1,+Inf]%topics% topics', array('%topics%' => $nb_topics), $nb_topics)),
    $topic_rule
    ) ?>, 
  <?php else:?>
    <?php echo link_to_if($display_topic_link, __('%topics% topics', array('%topics%'=>$nb_topics)), $topic_rule) ?>,
  <?php endif;?>
  <?php if($nb_posts<2):?>
  <?php echo link_to_if(
    $display_post_link,
    __(format_number_choice('[0]No message|[1]One message|(1,+Inf]%posts% messages', array('%posts%' => $nb_posts), $nb_posts)),
    $post_rule
   ) ?>
  <?php else:?>
    <?php echo link_to_if($display_post_link, __('%posts% messages', array('%posts%'=>$nb_posts)),  $post_rule) ?>
  <?php endif;?>
  
  <?php if(sfConfig::get('app_sfSimpleForumPlugin_use_feeds', true)): ?>
    <?php echo link_to(image_tag('/sfSimpleForumPlugin/images/feed-icon.png', 'align=top'), $feed_rule, 'title='.$feed_title) ?>
  <?php endif; ?>  

</div>

<?php //echo __('There is no topic in this discussion yet. Perhaps you would like to %start%?', array('%start%' =>  link_to(__('start a new one'), 'sfSimpleForum/createTopic?forum_name='.$forum->getStrippedName()))) ?></p>
