<?php 
/*
if(isset($clipid))
{
?>
clipSelected(5);
<?php }*/?>
<script  type="text/javascript">
/*
 * Init and setup FlowPlayer. This example file shows 'advanced' features like
 * playlists and configuring with JavaScript. FlowPlayer.html is a simpler example.
 *
 * NOTE: This file has been tested to work on FireFox only. It has some problems on IE.
 */
var flowPlayer;
function init()
{  
   if (document.getElementById)
   {
	  flowPlayer = document.getElementById("FlowPlayer");
   }
	setFlowPlayerConfig();
}
// wait for the page to fully load before initializing
window.onload = init;
function setFlowPlayerConfig()
{
  flowPlayer.setConfig(fpConf);
}
function onPlay(clip)
{  
  var queuedVideoId= videoPlayer.getClipIdFromUrl();
  if(queuedVideoId)
  {
    flowPlayer.ToClip(queuedVideoId);
    flowPlayer.DoPlay();
  }
}

function onLoadBegin(clip)
{
   currentIndex=flowPlayer.getCurrentClip();
   scroll(currentIndex);		  
}
// Playlist.
var clips = [<?php foreach($videos as $video): ?>
{ url:'<?php echo $video->getFilename();?>'},
 <?php endforeach; ?>];

// FlowPlayer configuration
var fpConf = {
    // for FMS:
    //	streamingServerURL: 'rtmp://cyzy7r959.rtmphost.com/flowplayer',
    // for red5:
	//streamingServerURL: 'rtmp://localhost:1935/oflaDemo',
	//streamingServerURL: 'http://localhost/creatvmd/fmpsv/videos/flowplayer-2.0.1/flowplayer/html/',
	//thumbsOnFLV: true,
	playList: clips,
	//showPlayList: false,
	showPlayList: true,
	baseURL: "/uploads/assets/videos",
	autoPlay: true,
	autoBuffering: false,
	startingBufferLength: 5,
	bufferLength: 10,
	loop: false,
	hideControls: false,
	initialScale: 'fill',
	showPlayListButtons: true,
	useNativeFullScreen: true
}

</script>
<!-- video-player -->			
<div class="video-player">
	<div class="bd">
      <div id="fp_container">To view the section below, please install the latest version of <br /><a href="http://www.adobe.com/go/getflashplayer" target="_top">Adobe Flash Player</a></div>
	
	<script type="text/javascript">
		// <![CDATA[
	  var fo = new SWFObject("/js/FlowPlayerClassic.swf", "FlowPlayer", "620", "550", "7", "#ffffff", true);
      // need this next line for local testing, it's optional if your swf is on the same domain as your html page
      fo.addParam("allowScriptAccess", "always");
      fo.addParam("allowFullScreen", "true");
	  fo.addParam("flashVars", "config={configInject: true}");
      fo.write("fp_container");
	  //
	  var swfArgs = ['/js/FlowPlayerClassic.swf', 'FlowPlayer', '650', '450', '9', '#ffffff'];
	  var videoPlayer = new YAHOO.extension.VideoPlayer(swfArgs);
	  videoPlayer.render('fp_container');
	  
		// ]]>
	</script>
</div>
</div>
<!-- /video-player -->	