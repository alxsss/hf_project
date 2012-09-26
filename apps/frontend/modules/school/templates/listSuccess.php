<?php use_helper('I18N') ?>
<div id="updates_left_column">
<?php if($sf_user->isAuthenticated()):?> 
 <?php include_component('friends', 'ulinks')?>
<?php else:?>
  <?php include_partial('home/inhemsinif')?>	    
<?php endif;?> 
</div>
<div id="right_column_user">
  <div class="graduated"><?php //echo __('I graduated school in')?> </div>
  <div class="choose_region"><?php echo __('Choose a region in order to find your school')?> </div>
  <?php include_partial('home/regions', array('regions'=>$regions))?>
</div>