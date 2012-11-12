jQuery.noConflict();
jQuery(document).ready(function() {
  jQuery('.playButton>img').live('click', function(e) { 
	 e.preventDefault();  
	 if(jQuery(this).attr('class')=='play_button_play')
	 {
	   jQuery('.play_button_stop').removeClass('play_button_stop').addClass('play_button_play'); 
	   jQuery(this).removeClass('play_button_play').addClass('play_button_stop');
	   song_url=jQuery(this).attr('song_url');
	   song_title=jQuery(this).attr('song_title');
	   jQuery('#user_player').load('/music_loadplaylist',{song_url:song_url, song_title:song_title});
	 }
	 else if(jQuery(this).attr('class')=='play_button_stop')
	 {
	   jQuery(this).removeClass('play_button_stop').addClass('play_button_play');
	   jQuery('#user_player').load('/nomusic',{});
	 }

   }); 
  jQuery('.addButton>img').live('click', function(e) { 
	 e.preventDefault();  
	 jQuery('#login').slideDown(1000);
   }); 
  
   jQuery('#music_search_form').submit(function(e){
    e.preventDefault();
    jQuery('#loader').show();
	jQuery('#loader_bd').show();
	jQuery('#search_button').hide();
	jQuery('#content_main_music').css('opacity', '0.33');
    jQuery('#content_main_music').load(jQuery(this).attr('action'), { query: jQuery('#search_keywords').attr('value') },
    function() {jQuery('#loader').hide();jQuery('#loader_bd').hide();jQuery('#search_button').show(); jQuery('#content_main_music').css('opacity', '1');});
	});
});