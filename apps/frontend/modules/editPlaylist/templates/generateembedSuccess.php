<?php 
if (!empty($playlist_music))
{
  print <<< END_HEADER
  <?xml version="1.0" encoding="UTF-8"?>
  <playlist version="1" xmlns="http://xspf.org/ns/0/">
	<!-- Playlist generated automatically using script from www.lasmit.com -->
    
    <trackList>

END_HEADER;
/*if ($_REQUEST['shuffle']=="true") {
		shuffle($files);
	} else {
    	asort($files);
	}
	
	$counter = $i = 0;
*/
 foreach ($playlist_music as $song)
 {
//	$url=$song->getMusic()->getUrl();
	$url='http://www.youtube.com/watch?v=s1abUEAMtZE?hl=en';
	if($song->getMusic()->getUserId()>1)
	{
	  $url='/uploads/assets/music/'.$url;
	  if(!$song->getMusic()->getVisibility())
	  {
	    if($song->getMusic()->getUserId()!=$user_id)
	    {
	   	   continue;
	    }	   
	   }
	 } 
	$title=$song->getMusic()->getTitle();
	$artist=$song->getMusic()->getArtist();
	//$album=$song->getMusic()->getAlbum();
	$album='';
	
	  
        print <<< END_TRACK
		<track>
			<location>{$url}</location>
			
			<!-- artist or band name -->
			<creator>{$artist}</creator>
			
			<!-- album name -->
			<album>{$album}</album>
			
			<!-- name of the song -->
			<title>{$title}</title>
		</track>	

END_TRACK;
}
	print <<< END_FOOTER
	</trackList>
</playlist>
END_FOOTER;
}
?>
