<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php include_http_metas() ?>
<?php include_metas() ?>
<?php include_title() ?>
<link rel="shortcut icon" href="/favicon.ico" />
</head>
<body> 
  <div id="content">
    <div id="header">    
      <?php include_partial('sidebar/univhead') ?>     
      <?php include_partial('sidebar/univhead_login') ?>  
    </div>      
    <div id="content_main">
	  <div id="updates_left_column">
      <?php if($sf_user->isAuthenticated()):?>
        <?php include_component('friends', 'ulinks')?>
      <?php else:?>
        <?php include_partial('home/inhemsinif')?>
      <?php endif;?>
     </div>
	 <div id="right_column_user">	
	   <div id="breadcrumb">
 	     <?php include_slot('hemsinif_breadcrumb') ?>
       </div>       
       <?php echo $sf_content ?>	  
     </div>
    </div>
	 <?php if(!($sf_params->get('module')=='message'&&$sf_params->get('action')=='show')):?>
	   <?php include_partial('friends/horizontal_ad')?>
	 <?php endif;?>
	<div id="footer">	
	 <?php include_partial('sidebar/univfoot') ?>
	</div>
  </div>
  <?php include_javascripts() ?>
  <?php if($sf_user->isAuthenticated()): ?>
    <link type="text/css" href="/hfchat/hfchatcss.php" rel="stylesheet" charset="utf-8">
    <script type="text/javascript" src="/hfchat/hfchatjs.php" charset="utf-8"></script>
  <?php endif;?>
</body>
</html>
