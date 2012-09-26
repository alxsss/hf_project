<?php echo use_helper('Javascript') ?>
<?php slot('first_update') ?>
  <?php if($play=='stop'):?>
    <?php include_partial('loadplaylist', array('song_title'=>$song_title, 'song_url'=>$song_url));?> 
  <?php else:?> 
     <?php include_partial('loadplaylist', array('song_title'=>'', 'song_url'=>''));?> 
 <?php endif;?>
<?php end_slot() ?>
 
<?php slot('second_update') ?>
    <?php include_partial($play, array('button_number'=>$button_number, 'song_title'=>$song_title, 'song_url'=>$song_url));?>
<?php end_slot() ?>

<?php  $play_button='play_button_'.$button_number?>

<?php echo javascript_tag(
  update_element_function('user_player', array(
    'content' => get_slot('first_update'),
  ))
  .
  update_element_function($play_button, array(
    'content' => get_slot('second_update'),
  )) 
) ?>