<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php include_http_metas() ?>
<?php include_metas() ?>

<?php include_title() ?>
<?php use_helper('Form') ?>
<script src="/js/jquery.js" type="text/javascript"></script>
<script src="/js/jquery.music.js" type="text/javascript"></script>
<link rel="shortcut icon" href="/favicon.ico" />
</head>
<body class="yui-skin-sam"> 
<div id="content">
   <div id="header">    
    <?php include_partial('sidebar/univhead_login') ?> 
    <?php include_partial('sidebar/univhead') ?>  
  </div> 

 <div class="search">
  <h2><i>create a playlist</i></h2>
<form action="<?php echo url_for('@music_search_ajax') ?>" method="post" id="music_search_form">
 <?php /* echo form_remote_tag(array('url'=> '@music_search_ajax', 'update' => 'content_main_music', 'before' => 'hide_submit()',   'complete' => 'show_submit()',
	   )) */?>
  <input type="text" name="query" value="<?php echo $sf_request->getParameter('query') ?>" id="search_keywords" size="55" />  
  <input id="search_button" type="submit" value="search" />
  <img id="loader" src="/images/loader.gif" style="vertical-align:  middle; padding: 0 10px 10px 10px;display: none;" />

  <div class="help">
    Enter some keywords (song, artist, ...)
  </div>
</form>
</div>
  <div id="login" style="display: none">
   <h3>Please sign-in first</h3>
    <span class="forgot_password"><?php echo link_to_function('cancel', visual_effect('blind_up', 'login', array('duration' => 0.5))) ?></span>
     <?php echo form_tag('@signin_music', 'id=loginform') ?>
     <div class="loginbox"><div class="loginbox_account">username:</div><?php echo input_tag('signin[username]') ?></div>
     <div class="loginbox"><div class="loginbox_account">password:</div> <?php echo input_password_tag('signin[password]') ?></div>
	 <?php if(strpos($sf_request->getUri(),'query'))
	       {
		     $uri=$sf_request->getUri();
		   }
		   else
		   {
		     $uri=$sf_request->getUri().'?query='.$sf_request->getParameter('query');
		   }
	?>
     <?php echo input_hidden_tag('referer', $sf_params->get('referer') ? $sf_params->get('referer') :$uri ) ?>
     <?php echo submit_tag('login') ?> <span class="forgot_password"><?php echo link_to('Forgot your password?', '@resetRequest') ?></span>
    </form>	
  </div>
 
<div id="content_main_music">
  <div id="loader_bd">
    <?php echo image_tag('loader_bd.gif', 'alt=loader')?>
  </div>
 <?php echo $sf_content ?>

</div>
	
<div id="content_bar_music">
  <div id="user_player">
  <?php echo link_to('explore this playlist','editPlaylist/show?playlist_id=77')?>
    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="350" height="170" id="xspf_player" align="middle">
      <param name="allowScriptAccess" value="sameDomain" />
      <param name="movie" value="/js/xspf_player.swf?playlist_url=<?php echo url_for('@generate_playlist?playlist_id=77') ?>&autoload=true&autoplay=false&shuffle=true" />
      <param name="quality" value="high" />
      <param name="bgcolor" value="#e6e6e6" />
      <embed src="/js/xspf_player.swf?playlist_url=<?php echo url_for('@generate_playlist?playlist_id=77') ?>&autoload=true&autoplay=false&shuffle=true" quality="high" bgcolor="#e6e6e6" width="350" height="170" name="xspf_player" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
    </object>	
  </div>

  <div id="fmpsv-right-ad">
 
  <script type="text/javascript"><!--
google_ad_client = "pub-9464659474547085";
/* 336x280, created 9/22/09 */
google_ad_slot = "5883029811";
google_ad_width = 336;
google_ad_height = 280;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
	
  </div>
      <?php //include_component_slot('sidebar') ?>

</div>
	
	 <!-- footer -->	
	<div id="footer">
	 <?php include_partial('sidebar/univfoot') ?>
	</div>
	<!-- /footer -->
  </div>
 
</body>
</html>
