<?php echo link_to_remote(image_tag('transparent.gif', 'id=play_button_image class=play_button_stop alt=stop title=stop'), array(
      'update' => 'result',
      'url'    => url_for('@video_refresh?play=play&button_number='.$button_number.'&video_id='.$video_id),
	  'script' => true,
      )) ?>  