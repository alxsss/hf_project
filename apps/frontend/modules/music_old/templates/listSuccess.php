<?php 
$stringData= '<?xml version="1.0" encoding="UTF-8"?>
<playlist version="0" xmlns = "http://xspf.org/ns/0/">
<trackList>';

?>
  <?php foreach ($music_list as $music): ?>
<?php $stringData.='<track><location>/uploads/assets/music/'.$music->getFilename().'</location>';
    $stringData.='<title>'.$music->getTitle().'</title></track>';?>
  <?php endforeach; ?> 
  <?php $stringData.= '</trackList></playlist>'; ?>
<h1>music</h1>

<object type="application/x-shockwave-flash" width="400" height="170" data="/js/xspf_player.swf?playlist_url=<?php echo $stringData;?>">
<param name="movie" 
value="/js/xspf_player.swf?playlist_url=<?php echo $stringData; ?>" />
</object>


<object type="application/x-shockwave-flash" width="400" height="170" data="/js/xspf_player.swf?playlist_url=/js/playlist.xspf">
<param name="movie" 
value="/js/xspf_player.swf?playlist_url=" />
</object>



<h1>Music List</h1>
<table>
<?php foreach ($music_list as $music): ?>
<tr><td>
<object id="xspf_player" width="400" height="15" align="middle" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000">
<param value="sameDomain" name="allowScriptAccess"/>
<param value="/js/xspf_player_slim.swf?song_url=<?php echo '/uploads/assets/music/'.$music->getFilename() ?>" name="movie"/>
<param value="high" name="quality"/>
<param value="#e6e6e6" name="bgcolor"/>
<embed width="400" height="15" align="middle" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" allowscriptaccess="sameDomain" name="xspf_player" bgcolor="#e6e6e6" quality="high" src="/js/xspf_player_slim.swf?song_url=<?php echo '/uploads/assets/music/'.$music->getFilename() ?>"/>
</object>


<object type="application/x-shockwave-flash" width="40" height="25" 
data="/js/musicplayer_f6.swf?song_url=<?php echo '/uploads/assets/music/'.$music->getFilename() ?>&song_title=<?php echo $music->getTitle() ?>">
<param name="movie" value="/js/musicplayer_f6.swf?song_url=<?php echo '/uploads/assets/music/'.$music->getFilename() ?>" />
</object>
</td>
<td><?php echo link_to('add', 'playlist/list?music_id='.$music->getId())?></td>
<td><?php echo $music->getTitle()?></td>
</tr>
<?php endforeach; ?>
</table>