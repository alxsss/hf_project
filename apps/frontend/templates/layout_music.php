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
<div id="content">
   <div id="header">    
    <?php include_partial('sidebar/univhead_login') ?> 
    <?php include_partial('sidebar/univhead') ?>  
  </div>   
 
 <div class="search">
 <h2 class="help">create a playlist</h2>
<form action="<?php echo url_for('@music_search') ?>" method="post">
  <input type="text" name="query" value="<?php echo $sf_request->getParameter('query') ?>" id="search_keywords" size="55" />
  <input type="submit" value="search" />
  <div class="help">
    Enter some keywords (song, artist, ...)
  </div>
</form>
</div>
 <?php include_partial('sidebar/signin') ?> 

    <div id="content_main">

      <?php echo $sf_content ?>
    </div>
	
    <div id="content_bar">
		<script type="text/javascript"><!--
google_ad_client = "pub-9464659474547085";
/* 120x600, created 9/22/09 */
google_ad_slot = "4009992255";
google_ad_width = 120;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script> 
    </div>
	
	 <!-- footer -->	
	<div id="footer">
	 <?php include_partial('sidebar/univfoot') ?>
	</div>
	<!-- /footer -->
  </div>
 
</body>
</html>

