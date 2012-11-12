jQuery.noConflict();
jQuery(document).ready(function()
{
  jQuery('.comment_actions>a').live('click', function(e) 
  { 
    e.preventDefault();
	jQuery(this).next().next().toggle();
   }); 
    
  jQuery('form').live('submit', function(e)
  {
     jQuery(this).children('.submit-row').show();      
  });
  jQuery('.delete_sg').live('click', function(e)
  {
	 e.preventDefault();	 
     id=jQuery(this).attr('id');
	 divid=jQuery(this).parents('.friend_suggestion');
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
      	if (hCheck && (vlen < e.valLength || ewidth != e.boxWidth)) e.style.height = "0px";
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