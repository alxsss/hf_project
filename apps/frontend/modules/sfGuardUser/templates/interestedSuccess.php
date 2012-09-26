<?php use_helper('User') ?>
 <?php echo link_to_user_interested_photo($sf_user, $photo)?>  
 (<?php echo $photo->getVote() -1?>)
