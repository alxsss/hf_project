<?php $playlist=array();?>
<?php foreach ($videolist_ytvideo as $i=>$ytvideo):?>
  <?php $playlist[]= $ytvideo->getYtvideoId();?>
<?php endforeach;?>
<?php
  $key=array_search($video_id,$playlist);
  //find array after key index
  $playlist1=array_slice($playlist,$key+1);
  //find array before  key index
  array_splice($playlist,$key);
  //merge arrays to get new array starting from the next to key index value and goyned with the array before key index
  $playlist_play=array_merge($playlist1, $playlist);
?>
<div id="loader_player">
  <?php echo image_tag('loader_bd.gif', 'alt=loader')?>
</div>
<object width="410" height="350">
<param name="movie" value="http://www.youtube.com/v/<?php echo $video_id?>?version=3&playlist=<?php echo implode(',',$playlist_play)?>&autoplay=1"></param>
<param name="allowFullScreen" value="true"></param>
<param name="allowScriptAccess" value="always"></param>
<embed src="http://www.youtube.com/v/<?php echo $video_id?>?version=3&playlist=<?php echo implode(',',$playlist_play)?>&autoplay=1"
  type="application/x-shockwave-flash"
  allowfullscreen="true"
  allowscriptaccess="always"
  width="410" height="350"
>
</embed>
</object>
