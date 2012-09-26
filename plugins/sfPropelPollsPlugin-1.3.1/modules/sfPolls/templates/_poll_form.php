<?php if (!empty($poll)): ?>
<?php use_stylesheet('/sfPropelPollsPlugin/css/sf_propel_polls.css'); ?>
<div id="sfPropelPollsPlugin">
  <h2>
    <?php echo $poll->getTitle() ?>
  </h2>
  <div class="poll_content">
    <?php use_helper('Text', 'Javascript') ?>
    <div id="cmp_poll_<?php echo $poll->getId() ?>">
    <?php if (empty($poll_results)): ?>
      <?php if ($poll->getDescription()): ?>
        <?php echo simple_format_text($poll->getDescription()) ?>
      <?php endif; ?>
      <?php echo form_remote_tag(array('url'    => '@sf_propel_polls_vote',
                                       'update' => 'cmp_poll_'.$poll->getId())) ?>
        <?php include_partial('sfPolls/poll_form_elements', array('poll' => $poll)) ?>
      </form>
    <?php else: ?>
    	<?php include_partial('sfPolls/resultsSuccess', 
    	   array('poll' => $poll, 'poll_results' => $poll_results, 'no_neader' => true)) ?>
    <?php endif; ?>
    </div>
  </div>
</div>
<?php endif; ?>