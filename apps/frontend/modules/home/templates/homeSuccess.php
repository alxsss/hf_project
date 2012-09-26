<?php use_helper('I18N') ?>
<div class="homepage">

  <div class="hf_logo"><img src="/images/hf_logo.png" /></div>
  <div class="hf_about"><?php echo __('Social network for finding and connecting with classmates and friends')?> </div>
   
  <div class="homepage_find_school">
    <?php echo link_to(__('find your school'), url_for('home/index'))?>
  </div>
  <div class="homepage_registration">
    <?php echo link_to(__('Registration'), '@register')?>
  </div>

 <div class="homepage_signin">
   <span class="toggle_to_login"><a href="#"><?php echo __('sign in')?></a></span>
   <?php include_partial('sidebar/signin')?>
 </div>
</div>
