<?php use_helper('I18N') ?>
<div id="updates_left_column">
  <?php if($sf_user->isAuthenticated()):?> 
   <?php include_component('friends', 'ulinks')?>
  <?php else:?>
    <?php include_partial('home/inhemsinif')?>	    
  <?php endif;?>
</div>
<div id="right_column_user">
  <div style="margin:5px 0 0 15px;">
    <?php echo __('Your request has been sent. The user needs to approve it')?>.
    <br>
    <?php echo __('Back to')?> <?php  echo link_to($friend->getUsername().__('\'s profile'), 'user/'.$friend->getUsername()) ?>
  </div>
  <div class="horizontal_ad">
<script type="text/javascript"><!--
google_ad_client = "pub-0181717197672047";
/* 728x90, created 10/18/10 */
google_ad_slot = "0174420504";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
  </div>


</div>
