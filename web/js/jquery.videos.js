jQuery.noConflict();
jQuery(document).ready(function() {
  jQuery('.playButton>img').live('click', function(e) { 
	 e.preventDefault();  
	 if(jQuery(this).attr('class')=='play_button_play')
	 {
	   jQuery('.play_button_stop').removeClass('play_button_stop').addClass('play_button_play'); 
	   jQuery(this).removeClass('play_button_play').addClass('play_button_stop');
	   video_id=jQuery(this).attr('video_id');
	   jQuery('#loader_player').show();
	   jQuery('#fmpsv_video_player').load('/playvideo',{video_id:video_id}, function(){jQuery('#loader_player').hide();});
	 }
	 else if(jQuery(this).attr('class')=='play_button_stop')
	 {
	   jQuery(this).removeClass('play_button_stop').addClass('play_button_play');
	   jQuery('#fmpsv_video_player').load('/novideo',{});
	 }

   }); 
  jQuery('.addButton>img').live('click', function(e) { 
	 e.preventDefault();  
	 jQuery('#login').slideDown(1000);
   }); 
  
   jQuery('#video_search_form').submit(function(e){
    e.preventDefault();
    jQuery('#loader').show();
	jQuery('#loader_bd').show();
	jQuery('#search_button').hide();
	jQuery('#videosearchResults').css('opacity', '0.33');
    jQuery('#videosearchResults').load(jQuery(this).attr('action'), { query: jQuery('#search_keywords').attr('value') },
    function() {jQuery('#loader').hide();jQuery('#loader_bd').hide();jQuery('#search_button').show(); jQuery('#videosearchResults').css('opacity', '1');});
	});
});
