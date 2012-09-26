<div id="fmpsv_player">
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="350" height="170" id="xspf_player" align="middle">
  <param name="allowScriptAccess" value="sameDomain" />
  <param name="movie" value="/js/xspf_player.swf?song_url=/uploads/assets/music/<?php echo $song->getUrl() ?>&song_title=<?php echo $song->getTitle() ?>&album=kingston&autoload=false&autoplay=true&shuffle=false" />
  <param name="quality" value="high" />
  <param name="bgcolor" value="#e6e6e6" />
  <embed src="/js/xspf_player.swf?song_url=/uploads/assets/music/<?php echo $song->getUrl() ?>&song_title=<?php echo $song->getTitle()?>&album=kingston&autoload=false&autoplay=true&shuffle=false" quality="high" bgcolor="#e6e6e6" width="350" height="170" name="xspf_player" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
</div>

<div id="fmpsv_playlist_info">
  <table id="playlist" cellpadding="2" cellspacing="1" border="0">
  <tbody>
    <th>Artist</th><th>Title</th><th>Action</th>
	
	   <?php if($song->getUserId()>1)
	         {
	           if(!$song->getVisibility())
	           {
	             if($song->getUserId()!=$user_id)
	             {
	   	          continue;
	              }	   
	            }
	         } ?>
			
       <tr>
         <td class="playlist_row"><?php echo $song->getArtist() ?></td>
	     <td class="playlist_row"><?php echo $song->getTitle() ?></td>
	     <td class="playlist_row">
	    
		   <?php if($song->getUserId()==$user_id):?>
		     <?php echo link_to(image_tag('edit.png', 'alt=edit title=edit'), 'music/edit?id='.$song->getId())?>
		   <?php endif;?>
  		   <?php echo link_to('<input type=submit value=add title="add to playlist">', 'playlist/list?music_id='.$song->getId())?>
  	     </td>
      </tr>
    </tbody>
    </table>  
</div>