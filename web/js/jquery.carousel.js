jQuery.noConflict();function mycarousel_getItemHTML(url)
{return'<a href="#"><img src="'+url+'" alt="" /><a>';};jQuery(document).ready(function(){jQuery('#mycarousel').jcarousel({});jQuery('.jcarousel-item>a>img').live('click',function(e)
{e.preventDefault();photo_id=jQuery(this).attr('photo_id');jQuery('#loader_bd').show();jQuery('#photospot').css('opacity','0.33');jQuery('#photospot').load('/showalbumphoto',{id:photo_id},function(){jQuery('#loader_bd').hide();jQuery('#photospot').css('opacity','1');});});});
