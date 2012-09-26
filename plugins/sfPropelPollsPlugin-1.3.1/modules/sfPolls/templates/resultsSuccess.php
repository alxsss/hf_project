<?php use_stylesheet('/sfPropelPollsPlugin/css/sf_propel_polls.css'); ?>
<h1><?php echo __('Poll') ?></h1>

<div id="sfPropelPollsPluginContent">
  <?php if (!empty($poll)): ?>
    <?php require '_resultsSuccess.php'; ?>
  <?php else: ?>
    <?php echo __('No poll yet.') ?>
  <?php endif; ?>
</div>