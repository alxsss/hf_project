<?php echo use_helper('Javascript') ?>
<?php slot('first_update') ?>
  <?php if($play=='stop'):?>
    <?php include_partial('playvideo', array('videoUrl'=>$videoUrl, 'video_id'=>$video_id));?> 
  <?php else:?> 
     <?php include_partial('playvideo', array('videoUrl'=>'', 'video_id'=>''));?> 
 <?php endif;?>
<?php end_slot() ?>
 
<?php slot('second_update') ?>
    <?php include_partial($play, array('button_number'=>$button_number, 'videoUrl'=>$videoUrl, 'video_id'=>$video_id));?>
<?php end_slot() ?>

<?php slot('third_update') ?>
    <?php include_partial('play', array('button_number'=>$button_number, 'videoUrl'=>$videoUrl, 'video_id'=>$video_id));?>
<?php end_slot() ?>

<?php  $play_button='play_button_'.$button_number?>
<?php $previous_button_number=$sf_user->getAttribute('previous_button_number');?>
<?php if($previous_button_number!=$button_number):?>
  <?php echo javascript_tag(
  update_element_function('play_button_'.$previous_button_number, array(
    'content' => get_slot('third_update'),
  ))
  )
  ?> 
<?php endif;?>
<?php echo javascript_tag(
  update_element_function('fmpsv_video_player', array(
    'content' => get_slot('first_update'),
  ))
  .
  update_element_function($play_button, array(
    'content' => get_slot('second_update'),
  )) 
) ?>
<?php $previous_button_number=$sf_user->setAttribute('previous_button_number', $button_number);?>