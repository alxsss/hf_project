<?php echo link_to_remote(image_tag('transparent.gif', 'id=play_button_image class=play_button_stop alt=stop title=stop'), array(
      'update' => 'result',
      'url'    => url_for('@music_refresh?play=play&button_number='.$button_number.'&song_url='.str_replace('/','^',urlencode($song_url)).'&song_title='.str_replace('/','^',urlencode($song_title))),
	  'script' => true,
      )) ?>  