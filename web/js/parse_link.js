jQuery.noConflict();
   jQuery(document).ready(function(){

   jQuery('#user_status_box').live('focusin', function(){jQuery('.submit_status_link_button').show();}).live('focusout', function(){setTimeout(function(){jQuery('.submit_status_link_button').hide(); },200);});
   jQuery('#post_link').live('click', function(e) {
        e.preventDefault();
        jQuery('#user_status_box').hide();
        jQuery('#atc_bar').show();
        jQuery('#url').show();
        jQuery('#attach').show();
        jQuery('#attach_content').hide();
        jQuery('#post_link_text').hide();
        jQuery('.post_links_elements_active').removeClass('post_links_elements_active').addClass('post_links_elements');
        jQuery(this).removeClass('post_links_elements').addClass('post_links_elements_active');
    });

   jQuery('#post_status').live('click', function(e) {
        e.preventDefault();
        jQuery('#atc_bar').hide();
        jQuery('#user_status_box').show();
        jQuery('.post_links_elements_active').removeClass('post_links_elements_active').addClass('post_links_elements');
        jQuery(this).removeClass('post_links_elements').addClass('post_links_elements_active');
    });

  jQuery('#user_feed_button').live('click', function(e) {
        e.preventDefault();
        var user_status_element_new = jQuery('.user_status_element_new');
        var user_status_box=jQuery('#user_status_box').attr('value');
        var user_status_box_title=jQuery('#user_status_box').attr('title');
        if(user_status_box==user_status_box_title)user_status_box='';
   if(user_status_box!='')
   {
     //execute status action
      jQuery('#user_status_box').css('background-color', '#CCCCCC');
      jQuery('.submit_status_link_button').hide();
      user_status_element_new.load(jQuery('#user_status_form').attr('action'), {
            user_status: user_status_box
       }, function() {
            user_status_element_new.fadeIn(), jQuery('#user_status_box').css('background-color', '#FFFFFF');
            jQuery('#user_status_box').val('');
            jQuery('.submit_status_link_button').show();
        });
   }
   else
   {     
        var post_link_text = jQuery('#post_link_text').attr('value');
        var post_link_text_title = jQuery('#post_link_text').attr('title');
        if(post_link_text==post_link_text_title) post_link_text='';
        var link_title=jQuery('#atc_title').text();
        var link_desc=jQuery('#atc_desc').text();
        var link_url=jQuery('#atc_url').text();
        var link_img_src=jQuery('#atc_images img[style="display: inline;"]').attr('src');
        //user_status_element_new.load(jQuery('#user_status_form').attr('action'), {
        user_status_element_new.load('links/postlink', {
            post_link_text: post_link_text, title:link_title, desc:link_desc, url:link_url, img_src: link_img_src
        }, function() {
            user_status_element_new.fadeIn(), jQuery('#user_status_box').css('background-color', '#FFFFFF');
            jQuery('#user_status_box').val('');
            jQuery('#attach_content').fadeOut('slow');
            jQuery('.post_links_elements_active').removeClass('post_links_elements_active').addClass('post_links_elements');
            jQuery('#post_status').removeClass('post_links_elements').addClass('post_links_elements_active');
            jQuery('#atc_bar').hide();
            jQuery('#user_status_box').show();
            jQuery('.submit_status_link_button').hide();
        });
     }
        user_status_element_new.removeAttr('class');
        user_status_element_new.addClass('user_status');
        user_status_element_new.before('<div class="user_status_element_new"></div>');
    });


   
      // delete event
      jQuery('#attach').bind("click", parse_link);
      function parse_link ()
      {
         var url=jQuery('#url').val();
         if( !url.match(/^[a-zA-Z]{1,5}:\/\//) )
         {
           url = 'http://' + url;
         }
         if(!isValidURL(url))
         {
            alert('Please enter a valid url.');
            return false;
         }
         else
         {
            jQuery('#atc_loading').show();
            jQuery('#atc_url').html(url);
            jQuery.post("links/fetch?url="+escape(url), {}, function(response){

               //Set Content
               jQuery('#atc_title').html(response.title);
               jQuery('#atc_desc').html(response.description);
               jQuery('#atc_price').html(response.price);

               jQuery('#atc_total_images').html(response.total_images);

               jQuery('#atc_images').html(' ');
               jQuery.each(response.images, function (a, b)
               {
                  jQuery('#atc_images').append('<img src="'+b+'" id="'+(a+1)+'">');
               });
               jQuery('#atc_images img').hide();

               //Flip Viewable Content
               jQuery('#attach_content').fadeIn('slow');
               jQuery('#atc_loading').hide();

               //show post_link_text and submit boxes and hide original parse box
               jQuery('.post_link_text').show();
               jQuery('.submit_status_link_button').show();
               jQuery('#url').hide();
               jQuery('#attach').hide();

               //Show first image
               jQuery('img#1').fadeIn();
               jQuery('#cur_image').val(1);
               jQuery('#cur_image_num').html(1);

               // next image
               jQuery('#next').unbind('click');
               jQuery('#next').bind("click", function(){
 var total_images = parseInt(jQuery('#atc_total_images').html());
                  if (total_images > 0)
                  {
                     var index = jQuery('#cur_image').val();
                     jQuery('img#'+index).hide();
                     if(index < total_images)
                     {
                        new_index = parseInt(index)+parseInt(1);
                     }
                     else
                     {
                        new_index = 1;
                     }

                     jQuery('#cur_image').val(new_index);
                     jQuery('#cur_image_num').html(new_index);
                     jQuery('img#'+new_index).show();
                  }
               });

               // prev image
               jQuery('#prev').unbind('click');
               jQuery('#prev').bind("click", function(){

                  var total_images = parseInt(jQuery('#atc_total_images').html());
                  if (total_images > 0)
                  {
                     var index = jQuery('#cur_image').val();
                     jQuery('img#'+index).hide();
                     if(index > 1)
                     {
                        new_index = parseInt(index)-parseInt(1);;
                     }
                     else
                     {
                        new_index = total_images;
                     }

                     jQuery('#cur_image').val(new_index);
                     jQuery('#cur_image_num').html(new_index);
                     jQuery('img#'+new_index).show();
                  }
               });
            });
         }
      };
   });
  function isValidURL(url)
   {
      var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?\.[a-zA-Z]{2,4}$/;

      if(RegExp.test(url)){
         return true;
      }else{
         return false;
      }
   }

