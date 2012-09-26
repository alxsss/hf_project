<?php echo link_to_remote(image_tag('transparent.gif', 'id=play_button_image class=play_button_play alt=play title=play'), array(
      'update' => 'result',
      'url'    => url_for('@video_refresh?play=stop&button_number='.$button_number.'&video_id='.$video_id),
	  'script' => true,
      )) ?>  