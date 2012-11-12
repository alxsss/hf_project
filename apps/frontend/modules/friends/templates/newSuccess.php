<?php use_helper('I18N') ?>
<div id="updates_left_column">
 <?php include_component('friends', 'ulinks')?>  
</div>
<div id="right_column_user">
  <div style="margin:5px 0 0 15px;">
    <?php 
      if(!empty($error))
      {
        echo '<span class="invitefrienderror">'.__($error).'</span>';
        echo '<br>';
        echo __('Back to')?> <?php  echo link_to($recepient->getUsername().__('\'s profile'), 'user/'.$recepient->getUsername());
      }
      else
      {
      ?>
         <?php echo __('Do you really want to add')?> <b><?php echo $friend->getUsername()?></b> <?php echo __('as a friend')?>?
         <?php include_partial('form', array('form' => $form)) ?>
      <?php }?>
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
