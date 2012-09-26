<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php include_http_metas() ?>
<?php include_metas() ?>

<?php include_title() ?>
<?php use_helper('Form') ?>

<script src="/js/jquery.js" type="text/javascript"></script>
<script src="/js/jquery.videos.js" type="text/javascript"></script>
<link rel="shortcut icon" href="/favicon.ico" />
<script type="text/javascript">
function hide_submit()
{
  var loader=document.getElementById('loader');
  var loader_bd=document.getElementById('loader_bd');
  var search_button=document.getElementById('search_button');
  var search_results=document.getElementById('videosearchResults');
  loader.style.display='inline';
  loader_bd.style.display='inline';
  search_button.style.display='none';
  search_results.style.opacity='0.33';
}
function show_submit()
{
  var loader=document.getElementById('loader');
  var loader_bd=document.getElementById('loader_bd');
  var search_button=document.getElementById('search_button');
  var search_results=document.getElementById('videosearchResults');
  loader.style.display='none';
  loader_bd.style.display='none';
  search_button.style.display='inline';
  search_results.style.opacity='1';
}
</script>
<style>
#header a.v{color:#999999;}
</style>
</head>
<body class="yui-skin-sam">
<div id="content">
   <div id="header">    
    <?php include_partial('sidebar/univhead_login') ?> 
    <?php include_partial('sidebar/univhead') ?>  
  </div>  

  
 <?php //use_helper('Javascript') ?>
 <div class="search">
 <h2 class="help">find video</h2>
<form action="<?php echo url_for('@video_search_ajax') ?>" method="post" id="video_search_form">

 <?php /* echo form_remote_tag(array('url'=> '@video_search_ajax', 'update' => 'videosearchResults', 'before' => 'hide_submit()',   
       'complete' => 'show_submit()',
       //'after' => 'show_submit()',
	   ))*/ ?>
  <input type="text" name="query" value="<?php echo $sf_request->getParameter('query') ?>" id="search_keywords" size="55" />  
  <input id="search_button" type="submit" value="search" />
  <img id="loader" src="/images/loader.gif" style="vertical-align:  middle; padding: 0 10px 10px 10px;display: none;" />

  <div class="help">
    Enter some keywords (title, tag, ...)
  </div>
</form>
</div>   
 <?php include_partial('sidebar/signin') ?> 
    <div id="content_main_video">
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