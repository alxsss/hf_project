<?php use_helper('I18N') ?>
<div id="updates_left_column">
  <?php if($sf_user->isAuthenticated()):?> 
   <?php include_component('friends', 'ulinks')?>
  <?php else:?>
    <?php include_partial('home/inhemsinif')?>	    
  <?php endif;?>
</div>
<div id="right_column_user">
  <?php include_partial('form', array('form' => $form)) ?>
  
<div class="content_bar_large">
<script type="text/javascript"><!--
google_ad_client = "pub-0181717197672047";
/* 250x250, created 10/14/10 */
google_ad_slot = "6406551105";
google_ad_width = 250;
google_ad_height = 250;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>  
</div>
