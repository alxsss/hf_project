jQuery.noConflict();
jQuery(document).ready(function()
{
    jQuery('#user_status_button').live('click', function(e)
    {
       e.preventDefault();
	   user_status_element_new=jQuery('.user_status_element_new');
       //user_status_element_new.fadeOut();
	   jQuery('#user_status_box').css('background-color', '#CCCCCC');
	   userstatus=jQuery('#user_status_box').attr('value');
	   user_status_element_new.load(jQuery('#user_status_form').attr('action'), { user_status: userstatus },
       function() {user_status_element_new.fadeIn(), jQuery('#user_status_box').css('background-color', '#FFFFFF');
       });	  
	   user_status_element_new.removeAttr('class');
	   user_status_element_new.addClass('user_status_element');
	   user_status_element_new.before('<div class="user_status_element_new"></div>');
	});
	
	jQuery('#user_status_box').focus(function(e)
    {
       jQuery('.submit-row').show();
	});	
	
	 jQuery('.delete_status>a').live('click', function(e)
    {
       e.preventDefault();
       user_status_element=jQuery(this).parents('.user_status_element').fadeOut();
	   status_id=jQuery(this).attr('status_id');
   	   user_status_element.load(jQuery(this).attr('action'), {id: status_id },
       function()  {user_status_element.fadeIn();
       });
	});	
	 
	jQuery('.user_status_element').live('mouseout', function(e)
    {
       jQuery(this).children('.delete_status').hide();      
	});
	jQuery('.user_status_element').live('mouseover', function(e)
    {
       jQuery(this).children('.delete_status').show();      
	});
	
	jQuery('.delete_school>a').live('click', function(e)
    {
       e.preventDefault();
       jQuery('#user_school').css('opacity', '0.33');
	   school_id=jQuery(this).attr('school_id');
   	   jQuery('#user_school').load('/deleteschool', {school_id: school_id},
       function()  {jQuery('#user_school').css('opacity', '1');
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
	

});	