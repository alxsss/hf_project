jQuery.noConflict();
jQuery(document).ready(function()
{
   jQuery('.jq_feed_pagination').live('click', function(e)
   {
     e.preventDefault();
     jQuery('#loader').show();
     jQuery('#loader_bd').show();
     jQuery('#search_button').hide();
     var action=jQuery(this).children('a').attr('href');
     jQuery('#itemsearchResults').css('opacity', '0.33');
     jQuery('#itemsearchResults').load(action,
     function() {jQuery('#loader').hide();jQuery('#loader_bd').hide();jQuery('#search_button').show(); jQuery('#itemsearchResults').css('opacity', '1');});

   });

  //handle comment submission
   jQuery('.status_comment_box_form').live('click', function(e)
   {
      //use click instead of submit  since submit does not work on ie
	  e.preventDefault();	 
      //user_status_comment_new=jQuery(this).parents('.add_status_comment').siblings('.user_status_comment_new');
	  var user_status_comment_new=jQuery(this).parents('form').parents('.status_comment_box').siblings('.add_status_comment').children('.user_status_comment_new');
	  var textarea=jQuery(this).parents('form').children('textarea');
	  textarea.css('background-color', '#CCCCCC');
	  var submit_button=jQuery(this);
	  submit_button.hide();
	  var item_id=jQuery(this).parents('form').children('input[name="item_id"]').attr('value');	 
      var item_user_id=jQuery(this).parents('form').children('input[name="item_user_id"]').attr('value');
	  var page=jQuery(this).parents('form').children('input[name="page"]').attr('value');	 
	  var comment=textarea.attr('value');
   	  user_status_comment_new.load(jQuery(this).parents('form').attr('action'), {comment: comment, item_id: item_id, item_user_id:item_user_id, page:page},
      function()  {textarea.css('background-color', '#FFFFFF');	textarea.val(''); submit_button.show();  
	  user_status_comment_new.removeAttr('class');
	  user_status_comment_new.addClass('comments');
	  user_status_comment_new.after('<div class="user_status_comment_new"></div>');
      });
	});
   //handle message  submission
   jQuery('.message_box_form').live('click', function(e)
   {
	  //use click instead of submit  since submit does not work on ie
       e.preventDefault();
        var message_new = jQuery(this).parents('form').parents('.message_box').siblings('.message_new');
        var textarea = jQuery(this).parents('form').children('textarea');
        var submit_button = jQuery(this);
        var message = jQuery(this).parents('form').serializeArray();
        if (jQuery.trim(message[0]['value'])) {
            textarea.css('background-color', '#CCCCCC');
            submit_button.hide();
            jQuery.ajax({
                type: 'POST',
                url: jQuery(this).parents('form').attr('action'),
                data: ({
                    message: message
                }),
                success: function(data) {
                    textarea.css('background-color', '#FFFFFF');
                    textarea.val('');
                    submit_button.show();
                    message_new.html(data);
                    message_new.removeAttr('class');
                    message_new.addClass('user_message');
                    message_new.after('<div class="message_new"></div>');
                }
            });
        } else {
            jQuery('.error_message').show();
        }
    });
   jQuery('#create_album_button').live('click', function(e)
   {
     //use click instead of submit  since submit does not work on ie
     e.preventDefault();
     var photo_edit = jQuery('#photo_edit');
     var submit_button = jQuery(this);
     var album_data = jQuery(this).parents('form').serializeArray();
     if (jQuery.trim(album_data[0]['value']))
     {
        photo_edit.css('background-color', '#CCCCCC');
        submit_button.hide();
            jQuery.ajax({
                type: 'POST',
                url: jQuery(this).parents('form').attr('action'),
                data: ({ album: album_data }),
                success: function(data) {
                    jQuery('#new_album').hide();
                    photo_edit.html(data);
                }
            });
        } else {
            jQuery('.error_message').show();
        }
    });

//recommend
   jQuery('.interested_block').live('click', function(e)
   {
	 e.preventDefault();	 
     var action=jQuery(this).children('a').attr('href');
	 jQuery(this).css('opacity', '0.33');
	 jQuery(this).load(action,
	 function()  {jQuery(this).css('opacity', '1.0');
	 });      	 
   });
   
  jQuery('.comment_actions>a').live('click', function(e) 
  { 
    e.preventDefault();
	jQuery(this).next().next().toggle();
   }); 
  
  jQuery('.toggle_to_login').live('click', function(e) 
  { 
    e.preventDefault();
	jQuery('#login').toggle(); 
   });

  jQuery('.delete_sg').live('click', function(e)
  {
	 e.preventDefault();	 
     var id=jQuery(this).attr('id');
	 var divid=jQuery(this).parents('.friend_suggestion');
	 divid.css('opacity', '0.2');
	 jQuery(this).parents('.friend_suggestion').load('/ignore', { id: id },
     function()  {divid.css('opacity', '1');
	 });      
  });  
  //remove default text
  jQuery('.defaultText').focus(function(srcc)
  {
    if (jQuery(this).val() == jQuery(this)[0].title)
    {
      jQuery(this).removeClass('cleardefault');
      jQuery(this).val("");
    }
  });    
  jQuery('.defaultText').blur(function()
  {
    if (jQuery(this).val() == "")
    {
      jQuery(this).addClass('cleardefault');
      jQuery(this).val(jQuery(this)[0].title);
    }
  });
  //jQuery('.defaultText').blur();
  //delete friend
  jQuery('.friend_del').live('click', function(e)
  {
	 e.preventDefault();	 
     var friend_id=jQuery(this).children('a').attr('friend_id');
	 var user_id=jQuery(this).children('a').attr('user_id');
	 var div_friend=jQuery(this).parents('.user_friend');
	 div_friend.css('opacity', '0.2');
	 div_friend.load('/friendremove', { user_id:user_id, friend_id: friend_id},
     function()  {div_friend.removeClass('user_album');div_friend.fadeOut();
	 });      
  }); 
  jQuery('.group_user_del').live('click',function(e)
  {
	  e.preventDefault();
	  var div_friend=jQuery(this).parents('.user_friend');
	  div_friend.css('opacity','0.2');
	  div_friend.load(jQuery(this).children('a').attr('href'),function(){div_friend.removeClass('user_album');div_friend.fadeOut();
	  });
  });
  //delete guest
  jQuery('.guest_del').live('click', function(e)
  {
	 e.preventDefault();	 
     var guest_id=jQuery(this).children('a').attr('guest_id');
	 var div_guest=jQuery(this).parents('.user_friend');
	 div_guest.css('opacity', '0.2');
	 div_guest.load('/guestremove', { guest_id:guest_id},
     function()  {div_guest.removeClass('user_friend');div_guest.fadeOut();
	 });      
  }); 
  //deny request
  jQuery('.deny').live('click',function(e){
	e.preventDefault();
	var div_item=jQuery(this).parents('.request');
	div_item.css('background-color', '#CCCCCC');
	div_item.load(jQuery(this).attr('href'),function(){div_item.css('background-color', '#fff')
	});
  });
  //approve request
  jQuery('.approve').live('click',function(e){
    e.preventDefault();
    var item_id=jQuery(this).attr('item_id');
    var id=jQuery(this).attr('id');
	var div_item=jQuery(this).parents('.request');
	div_item.css('background-color', '#CCCCCC');
	div_item.load(jQuery(this).attr('href'),{id:id,item_id:item_id},function(){div_item.css('background-color', '#fff')
    });
  });
  //delete photo comment
	jQuery('.delete_comment').live('click', function(e)
   {
	 e.preventDefault();	 
     var action=jQuery(this).children('a').attr('href');	 
	 var comments=jQuery(this).parents('.comments');
	 comments.css('opacity', '0.33');
	 comments.load(action,
	 function()  {comments.fadeOut();
	 });      
  }); 
 //delete url item
	jQuery('.delete_item').live('click', function(e)
   {
	 e.preventDefault();	 
         var action=jQuery(this).children('a').attr('href');	 
	 var items=jQuery(this).parents('.items');
	 items.css('opacity', '0.33');
	 items.load(action,
	 function()  {items.fadeOut();
	 });      
  });  
  //profile page js
  jQuery('#user_status_button').live('click', function(e)
    {
       e.preventDefault();
	   var user_status_element_new=jQuery('.user_status_element_new');
	   jQuery('#user_status_box').css('background-color', '#CCCCCC');
	   jQuery('.submit-row').hide();
	   var userstatus=jQuery('#user_status_box').attr('value');
	   user_status_element_new.load(jQuery('#user_status_form').attr('action'), { user_status: userstatus },
       function() {user_status_element_new.fadeIn(), jQuery('#user_status_box').css('background-color', '#FFFFFF'); jQuery('#user_status_box').val(''); jQuery('.submit-row').show();
       });	  
	   user_status_element_new.removeAttr('class');
	   user_status_element_new.addClass('user_status');
	   user_status_element_new.before('<div class="user_status_element_new"></div>');
	});
	
	jQuery('#user_status_box').focus(function(e)
    {
       jQuery('.submit-row').show();
	});	
	
	 jQuery('.delete_status>a').live('click', function(e)
    {
       e.preventDefault();
       var user_status=jQuery(this).parents('.user_status').fadeOut();
	   var status_id=jQuery(this).attr('status_id');
   	   user_status.load(jQuery(this).attr('action'), {id: status_id },
       function()  {user_status.fadeIn();
       });
	});	
	 
	jQuery('.user_status').live('mouseout', function(e)
    {
       jQuery(this).children('.delete_status').hide();      
	});
	jQuery('.user_status').live('mouseover', function(e)
    {
       jQuery(this).children('.delete_status').show();      
	});
	//pager of statuses
	jQuery('.user_updates').live('click', function(e)
   {
	 e.preventDefault();	 
     var action=jQuery(this).children('a').attr('href');
	 jQuery(this).load(action, {},
     function()  {jQuery(this).removeClass('user_updates');
	 });      
  });	
	jQuery('.delete_school>a').live('click', function(e)
    {
       e.preventDefault();
       var user_school_element=jQuery(this).parents('.user_school_element').fadeOut();
	   var school_id=jQuery(this).attr('school_id');
   	   user_school_element.load('/deleteschool', {school_id: school_id},
       function()  {user_school_element.fadeIn();
       });
	});	
	
	jQuery('.user_school_element').live('mouseout', function(e)
    {
       jQuery(this).children('.delete_school').hide();      
	});
	jQuery('.user_school_element').live('mouseover', function(e)
    {
       jQuery(this).children('.delete_school').show();      
	});
	jQuery('#friend_invite').click(function(){toggleCheckboxes('#friend_invite', 'markinvite', true);});
   //show tooltip
	jQuery('.photo_rating').live('mouseenter', function()
	{	
	  var alt=jQuery(this).attr('alt');
	  jQuery('#popup-'+alt).show();
	});
	jQuery('.photo_rating').live('mouseout',function () {
		var alt=jQuery(this).attr('alt');
		jQuery('#popup-'+alt).hide();
	});
jQuery('.sf_asset_action_add_file').click(function(){setInterval("showUpload()", 1000)});function showUpload(){var progress_key=jQuery('#progress_key').attr.val();jQuery.getJSON('/sfMediaLibrary/upload', {progress_key: progress_key}, function JSON(json){jQuery('#uploadprogressbar').show();jQuery('#uploadprogressbar').progressBar(eval(json.current/json.total*100));} );}
//upload progress bar
jQuery('#uploadprogressbar').progressBar();
	//photo rating
	jQuery('#photo_rating').raty();
  // initialize all expanding textareas
  jQuery("textarea[class*=expand]").TextAreaExpander(); 
  
});
//textexpander plugin
(function(jQuery)
{
  // jQuery plugin definition
  jQuery.fn.TextAreaExpander = function(minHeight, maxHeight)
  {
    var hCheck = !(jQuery.browser.msie || jQuery.browser.opera);
	// resize a textarea
	function ResizeTextarea(e)
	{
      // event or initialize element?
	  e = e.target || e;
      // find content length and box width
	  var vlen = e.value.length, ewidth = e.offsetWidth;
	  if (vlen != e.valLength || ewidth != e.boxWidth)
	  {
      	if (hCheck && (vlen < e.valLength || ewidth != e.boxWidth)) e.style.height = "24px";
		var h = Math.max(e.expandMin, Math.min(e.scrollHeight, e.expandMax));
        e.style.overflow = (e.scrollHeight > h ? "auto" : "hidden");
		e.style.height = h + "px";
        e.valLength = vlen;
		e.boxWidth = ewidth;
	   }
	   return true;
	};
	function hideCommentButton(){};
	function showCommentButton()
	{
	  jQuery('.submit-row').hide();
      jQuery(this).next().show();
	};
	// initialize
	this.each(function()
	{
      // is a textarea?
	  if (this.nodeName.toLowerCase() != "textarea") return;
      // set height restrictions
	  var p = this.className.match(/expand(\d+)\-*(\d+)*/i);
	  this.expandMin = minHeight || (p ? parseInt('0'+p[1], 10) : 0);
	  this.expandMax = maxHeight || (p ? parseInt('0'+p[2], 10) : 99999);
      // initial resize
	  ResizeTextarea(this);
      // zero vertical padding and add events
	  if (!this.Initialized)
	  {
		this.Initialized = true;
		jQuery(this).css("padding-top", 0).css("padding-bottom", 0);
		jQuery(this).bind("keyup", ResizeTextarea).bind("focus", ResizeTextarea).bind("focus", showCommentButton).bind("blur", hideCommentButton);			
	  }
  });
  return this;
 };
})(jQuery);
(function(jQuery) {
	jQuery.fn.raty = function(settings) {
	options = jQuery.extend({}, jQuery.fn.raty.defaults, settings);		// Merge (no deep) the default with settings, without alter the default. Global!

		if (this.attr('id') === undefined) {								// If the script is invalid then the script stops and write the error in the console.
			debug('Invalid selector!'); return;
		}
       //add these vars to display user ratings 
	    var start=jQuery('#photo_rating').attr('rate');
	    var read_only=jQuery('#photo_rating').attr('read_only');
        options.readOnly=read_only;
		options.start=start;
		$this = jQuery(this);									// Keep the container in a global variable for public functions. Global!
		if (options.number > 30) {								// A safe value to prevent malicious code.
			options.number = 30;
		}
		if (options.path.substring(options.path.length - 1, options.path.length) != '/') {			// Configure the path if it no ends with bar.
			options.path += '/';
		}
		// TODO: Using var for values that will be used into a function later, to keep the current value and not the last one. Why, Mr. Anderson? Why? 
		var containerId = $this.attr('id');							// Used in all components because the ID of the container in theory not be repeated.
		var path = options.path;
		var starOff = options.starOff;
		var starOn = options.starOn;
		var onClick = options.onClick;
        var photo_id=jQuery(this).attr('photo_id');
	   
		var start = 0;
		if (!isNaN(options.start) && options.start > 0) {																// Start with a default value.
			start = (options.start > options.number) ? options.number : options.start;									// Make sure the start value is not bigger than number of stars.
		}

		var hint = '';
		for (var i = 1; i <= options.number; i++) {																					// Append the img stars into container.
			hint = (options.number <= options.hintList.length && options.hintList[i - 1] !== null) ? options.hintList[i - 1] : i;	// Avoids a nonexistent index (undefined) and Ensures that the hint is to be applied, it means to be different from null. Otherwise applies the current number.

			starFile = (start >= i) ? options.starOn : options.starOff;
			$this.append('<img id="' + containerId + '-' + i + '" src="' + options.path + starFile + '" alt="' + i + '"  class="' + containerId + '"/>').append((i < options.number) ? '&nbsp;' : '');
		}
		$this.css('width', options.number * 20)							// Adjust de width of container. Each star have 16px for default and 4px of space, it is a little bit more for safety Unbuntu's FF.
		.append('<input id="' + containerId + '-score" type="hidden" name="' + options.scoreName + '"/>');				// Field to keep the score of each container.
        jQuery('#' + containerId + '-score').val(start);			// Put de current score into hidden input, even if it is zero. TODO: empty, null or zero?
     	
		if (!options.readOnly)
		{			// If readOnly is true, the mouse functions wont be binded. I don't call de function $.fn.readOnly for otimization, because i don't need bind to after unbind the mouseenter, mouseleave and click.
			
			
			jQuery('img.' + containerId).live('mouseenter', function()
			{				// When mouseover. I used mouseenter for avoid childrens take off the focus.
				//var className = $(this).attr('class');				// Class name of the star selected.
			
			  
			   var qtyStar = jQuery('img.' + containerId).length;						// How many stars have this class name.
      		   if(!options.readOnly)
			   {
				for (var i = 1; i <= qtyStar; i++)
				{																	// For each img star i ask if it number is less then the selected star and turn its on, or then turn its of.
					if (i <= this.alt)
					{
						jQuery('img#' + containerId + '-' + i).attr('src', path + starOn);
					}
					else
					{
						jQuery('img#' + containerId + '-' + i).attr('src', path + starOff);
					}
				}
			 }
			});
			
			jQuery('img.' + containerId).live('click', function() {			// When mouseclick i keep the score of clicked star into a hidden field with name container.id + -score.
				jQuery('input#' + containerId + '-score').val(this.alt);	// Put de current score into hidden input. The class name of the star selected is equals ID container.
				
				options.readOnly=1;
				jQuery.ajax({
							url: "/frontend_dev.php/rate",
							//global: false,
							//type: "POST",
							data: ({photo_id : photo_id, rate:this.alt}),
							//dataType: "html",
							//async:false,
							//success: function(msg){alert(msg);}
							 });
				
				if (onClick) {																							// If onClick is activated, the callback funtion of it is called. 
		          onClick(this.alt);
		        }
			});

			$this.live('mouseleave', function() {			// When mouseleave container, i get the score value and set the star. I used mouseleave for avoid childrens take off the focus. 
											
				var qtyStar = jQuery('img.' + containerId).length;																// How many stars have this class name.
				var score = jQuery('input#' + containerId + '-score').val();													// Get the last score.
      		   if(!options.readOnly)
			   {
				for (var i = 1; i <= qtyStar; i++) {
					if (i <= score) {
						jQuery('img#' + containerId + '-' + i).attr('src', path + starOn);
					} else {
						jQuery('img#' + containerId + '-' + i).attr('src', path + starOff);
					}
				}}
			}).css('cursor', 'pointer');																				// Set de pointer cursor because de stars are active.
		}
		else
		{
			$this.css('cursor', 'default');																				// Set de default cursor because de star are inactive.
		}
		return $this;																									// Return the self container for Method Chaining.
	};//end of raty

	jQuery.fn.raty.defaults = {																								// Sets the defaults settings as an attribute of the function. ($.fn.raty.defaults.start = '3';)
		hintList:		['bad', 'poor', 'regular', 'good', 'gorgeous'],													// A hint information for default 5 stars.
		number:			5,																								// Number of star.
		path:			'/images',																							// Path of images.
		readOnly:		false,																							// read-only or not.
		scoreName:		'score',																						// The name of target score.
		start:			0,																								// Start with a score value.
		starOff:		'star-off.png',																					// The image of the off star.
		starOn:			'star-on.png'																					// The image of the on star.
		//onClick:		function() { alert('clicked!'); }																// A default function can to be setted here.
	};

	jQuery.fn.raty.readOnly = function(boo) {																				// Public function to start a rating read only or not.
		if (boo) {
			jQuery('img.' + $this.attr('id')).die();																			// Unbind all functions of the stars.
			$this.css('cursor', 'default').die();																		// Unbind all functions of the container.
		} else {																										// Otherwise rebind that functions. 
			liveEnter();
			liveLeave();
			liveClick();
			$this.css('cursor', 'pointer');
		}
		return jQuery.fn.raty;
	};

	jQuery.fn.raty.start = function(start) {																					// Public function to initialize with a default value.
		initialize(start);
		return jQuery.fn.raty;
	};

	jQuery.fn.raty.click = function(score) {																					// Public function to click in a star.
		var star = (score >= options.number) ? options.number : score;
		initialize(star);
		if (options.onClick) {																							// If onClick is enabled, it is called automatic when start value is setted.
			options.onClick(star);
		} else {
			debug('You should add the "onClick: function() {}" option.');
		}
		return jQuery.fn.raty;
	};
	
	// TODO: functions are repeated on purpose for now! Because options.xxx should be used here and works as current value, unlike the function body. Why, Mr. Anderson? Why?
	function liveEnter() {
		var id = $this.attr('id');
		jQuery('img.' + id).live('mouseenter', function() {	// When mouseover. I used mouseenter for avoid childrens take off the focus.
			var qtyStar = jQuery('img.' + id).length;		// How many stars have this class name.

			for (var i = 1; i <= qtyStar; i++) {// For each img star i ask if it number is less then the selected star and turn its on, or then turn its of.
				if (i <= this.alt) {
					jQuery('img#' + id + '-' + i).attr('src', options.path + options.starOn);
				} else {
					jQuery('img#' + id + '-' + i).attr('src', options.path + options.starOff);
				}
			}
		});
	};
	
	function liveLeave() {
		alert('liveLeave');
		var id = $this.attr('id');
		$this.live('mouseleave', function()
	{					// When mouseleave container, i get the score value and set the star. I used mouseleave for avoid childrens take off the focus. 
			var qtyStar = jQuery('img.' + id).length;			// How many stars have this class name.
			var score = jQuery('input#' + id + '-score').val();		// Get the last score.

			for (var i = 1; i <= qtyStar; i++) {
				if (i <= score) {
					jQuery('img#' + id + '-' + i).attr('src', options.path + options.starOn);
				} else {
					jQuery('img#' + id + '-' + i).attr('src', options.path + options.starOff);
				}
			}
		});																												// Set de pointer cursor because de stars are active.
	};

	function liveClick()
	{
		alert('liveClick');
		var id = $this.attr('id');
		jQuery('img.' + id).live('click', function() {	// When mouseclick i keep the score of clicked star into a hidden field with name container.id + -score.
			jQuery('input#' + id + '-score').val(this.alt);	// Put de current score into hidden input. The class name of the star selected is equals ID container.
			options.readOnly=true;
		});
	};

	function initialize(start)
	{																						// Initializes with a default value.
		var id = $this.attr('id');
		var qtyStar = jQuery('img.' + id).length;																			// How many stars have this class name.
		jQuery('input#' + id + '-score').val(start);																			// Set de start value.

		for (var i = 1; i <= qtyStar; i++) {
			if (i <= start) {
				jQuery('img#' + id + '-' + i).attr('src', options.path + options.starOn);
			} else {
				jQuery('img#' + id + '-' + i).attr('src', options.path + options.starOff);
			}
		}
	};
	
	function debug(message)
	{																							// Throws error messages in the browser console.
		if (window.console && window.console.log) {
			window.console.log(message);
		}
	};

})(jQuery);
