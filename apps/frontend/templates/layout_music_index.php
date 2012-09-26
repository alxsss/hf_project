<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php include_http_metas() ?>
<?php include_metas() ?>

<?php include_title() ?>
<?php use_helper('Form') ?>

<link rel="shortcut icon" href="/favicon.ico" />
<style>
#header a.m{color:#999999;}
</style>
</head>
<body>
<?php //echo memory_get_usage()?>
<div id="content">
   <div id="header">    
    <?php include_partial('sidebar/univhead_login') ?> 
    <?php include_partial('sidebar/univhead') ?>  
  </div>   

<div class="search_music">
 <h2 class="help_music">create playlist</h2>
<form action="<?php echo url_for('@music_search') ?>" method="post">
  <input type="text" name="query" value="<?php echo $sf_request->getParameter('query') ?>" id="search_keywords" size="55" />
  <input type="submit" value="search" />
  <div class="help">
    Enter some keywords (song, artist, ...)
  </div>
</form>
</div>
    <div id="content_main_music">
      <?php echo $sf_content ?>
    </div>    
	
	 <!-- footer -->	
	<div id="footer">
	 <?php include_partial('sidebar/univfoot') ?>
	</div>
	<!-- /footer -->
  </div>
</body>
</html>