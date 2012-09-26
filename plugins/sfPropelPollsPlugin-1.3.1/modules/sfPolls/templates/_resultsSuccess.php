<?php if (!empty($poll)): ?>
  <?php use_helper('Text', 'Poll', 'I18N') ?>
  <?php if (empty($no_neader)): ?>
  <h2><?php echo $poll->getTitle() ?></h2>
  <?php endif; ?>
  <?php if ($poll->getDescription()): ?>
    <?php echo simple_format_text($poll->getDescription()) ?>
  <?php endif; ?>
  
  <?php if (isset($poll_results) && count($poll_results) > 0): ?>
  <ol class="sf_poll_results">
  <?php
  $voters = 0;
  foreach ($poll_results as $answer_id => $answer_result): ?>
    <li><?php echo $answer_result['name'] ?>: 
      <strong style="border-width:<?php echo poll_get_bar_width($answer_result['percent'], !empty($no_neader)) ?>px;">
        <?php echo $answer_result['percent'] ?>%</strong>
    </li>
    <?php $voters += $answer_result['count'];
  endforeach; ?>
  </ol>
  <?php if ($voters): ?>
    <div class="voters"><?php echo $voters ?> <?php echo __('Voters') ?></div>
  <?php endif; ?>
  <?php if ($poll->getIsActive() !== true): ?>
    <div class="comment"><?php echo __('Votes for this poll are closed') ?></div>
  <?php endif; ?>
  <?php else: ?>
    <?php echo __('This poll has no available answers to show the results for')?>.
  <?php endif; ?>
<?php endif; ?>