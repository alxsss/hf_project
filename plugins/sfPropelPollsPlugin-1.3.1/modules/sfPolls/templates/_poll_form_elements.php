<?php use_helper('I18N', 'Form') ?>
<?php echo input_hidden_tag('poll_id', $poll->getId()) ?>

<?php foreach ($poll->getAnswers() as $answer): ?>
  <p id="poll_<?php echo $poll->getId() ?>_answer_<?php echo $answer->getId() ?>">
    <?php $dom_id = 'choice_'.$poll->getId().'_'.$answer->getId() ?>
    <?php echo radiobutton_tag('answer_id', 
                               $answer->getId(), 
                               false,
                               'id='.$dom_id) ?>
    <?php echo label_for($dom_id, $answer->getName()) ?>
  </p>
<?php endforeach; ?>
<div class="buttons">
  <?php echo submit_tag(__('Vote'), array('class' => 'btn greyM flLeft')) ?>
  <?php echo link_to(__('Results'), 
                            '@sf_propel_polls_results?id=' . $poll->getId(), 
                            array('class' => 'btn greyM flRight')) ?>
</div>