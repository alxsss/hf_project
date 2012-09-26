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
        $url='http://o-o.preferred.sjc07s11.v2.lscache8.c.youtube.com/videoplayback?sparams=id%2Cexpire%2Cip%2Cipbits%2Citag%2Csource%2Calgorithm%2Cburst%2Cfactor%2Ccp&fexp=906717%2C909702%2C909601%2C901604&algorithm=throttle-factor&itag=34&ip=209.0.0.0&burst=40&sver=3&signature=6BDDE1995A1644F30767B8915971CE6F6F196854.B2A1C1D5BF5718504B55D2E396E56BC0D7516382&source=youtube&expire=1325644547&key=yt1&ipbits=8&factor=1.25&cp=U0hRSlZPUl9JUUNOMV9OSVZGOkpzemtXeE5ld0g1&id=b3569b50400cb591';

	//$url=$song->getMusic()->getUrl();
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
