<?php use_helper('I18N')?>
<div id="languages"><ul id="laglinks"><?php include_component('sfLanguageSwitch', 'get') ?> </ul></div>
<div id="fter">
  <ul>
   <li class="first"><?php echo link_to(__('home'), '@homepage') ?></li>
   <?php //echo link_to(__('terms of service'), '@ts') ?>
   <li><?php echo link_to(__('contact us'), '@contact') ?></li>  
   <li><?php echo link_to(__('groups'), '@sf_social_group_list') ?></li>
   <li><?php echo link_to(__('events'), '@sf_social_event_list') ?></li>
   <li><?php echo link_to(__('help'), '@help') ?></li>
    <li style="display:none"><?php echo link_to(__('Gift Guru'), 'http://www.gift-guru.com/') ?></li>
  </ul>
</div>
<div id="copyright">
  <cite>Copyright &copy; 2010 hemsinif.  <?php //echo __('All rights reserved.')?></cite>
</div>
