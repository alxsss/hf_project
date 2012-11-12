jQuery.noConflict();
jQuery(document).ready(function() {
    jQuery('.delete_item').live('click', function(e) {
        e.preventDefault();
        var action = jQuery(this).children('a').attr('href');
        var items = jQuery(this).parents('.items');
        items.css('opacity', '0.33');
        items.load(action, function() {
            items.fadeOut();
        });
    });
    jQuery('.jq_feed_pagination').live('click', function(e) {
        e.preventDefault();
        jQuery('#loader').show();
        jQuery('#loader_bd').show();
        jQuery('#search_button').hide();
        var action = jQuery(this).children('a').attr('href');
        jQuery('#itemsearchResults').css('opacity', '0.33');
        jQuery('#itemsearchResults').load(action, function() {
            jQuery('#loader').hide();
            jQuery('#loader_bd').hide();
            jQuery('#search_button').show();
            jQuery('#itemsearchResults').css('opacity', '1');
        });
    });
    jQuery('#create_album_button').live('click', function(e) {
        e.preventDefault();
        var photo_edit = jQuery('#photo_edit');
        var submit_button = jQuery(this);
        var album_data = jQuery(this).parents('form').serializeArray();
        if (jQuery.trim(album_data[0]['value'])) {
            photo_edit.css('background-color', '#CCCCCC');
            submit_button.hide();
            jQuery.ajax({
                type: 'POST',
                url: jQuery(this).parents('form').attr('action'),
                data: ({
                    album_data: album_data
                }),
                success: function(data) {
                    jQuery('#new_album').hide();
                    submit_button.show();
                    photo_edit.html(data);
                }
            });
        } else {
            jQuery('.error_message').show();
        }
    });
    jQuery('.status_comment_box_form').live('click', function(e) {
        e.preventDefault();
        var user_status_comment_new = jQuery(this).parents('form').parents('.status_comment_box').siblings('.add_status_comment').children('.user_status_comment_new');
        var textarea = jQuery(this).parents('form').children('textarea');
        textarea.css('background-color', '#CCCCCC');
        var submit_button = jQuery(this);
        submit_button.hide();
        var item_id = jQuery(this).parents('form').children('input[name="item_id"]').attr('value');
        var item_user_id = jQuery(this).parents('form').children('input[name="item_user_id"]').attr('value');
        var page = jQuery(this).parents('form').children('input[name="page"]').attr('value');
        var comment = textarea.attr('value');
        user_status_comment_new.load(jQuery(this).parents('form').attr('action'), {
            comment: comment,
            item_id: item_id,
            item_user_id: item_user_id,
            page: page
        }, function() {
            textarea.css('background-color', '#FFFFFF');
            textarea.val('');
            submit_button.show();
            user_status_comment_new.removeAttr('class');
            user_status_comment_new.addClass('comments items');
            user_status_comment_new.after('<div class="user_status_comment_new"></div>');
        });
    });
    jQuery('.message_box_form').live('click', function(e) {
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
    jQuery('.interested_block').live('click', function(e) {
        e.preventDefault();
        var action = jQuery(this).children('a').attr('href');
        jQuery(this).css('opacity', '0.33');
        jQuery(this).load(action, function() {
            jQuery(this).css('opacity', '1.0');
        });
    });
    jQuery('.comment_status').live('click', function(e) {
        e.preventDefault();
        jQuery(this).parent().siblings('.status_comment_box').toggle('slow');
    });
    jQuery('.toggle_to_login').live('click', function(e) {
        e.preventDefault();
        jQuery('#login').toggle('slow');
    });
    jQuery('.create_album').live('click', function(e) {
        e.preventDefault();
        jQuery('#new_album').toggle('slow');
    });
    jQuery('.hide_create_album').live('click', function(e) {
        e.preventDefault();
        jQuery('#new_album').toggle('slow');
    });
    jQuery('.delete_sg').live('click', function(e) {
        e.preventDefault();
        var id = jQuery(this).attr('id');
        var divid = jQuery(this).parents('.friend_suggestion');
        divid.css('opacity', '0.2');
        jQuery(this).parents('.friend_suggestion').load('/ignore', {
            id: id
        }, function() {
            divid.css('opacity', '1');
        });
    });
    jQuery('.defaultText').live('focus', function(srcc) {
        if (jQuery(this).val() == jQuery(this)[0].title) {
            jQuery(this).removeClass('cleardefault');
            jQuery(this).val("");
        }
    });
    jQuery('.defaultText').blur(function() {
        if (jQuery(this).val() == "") {
            jQuery(this).addClass('cleardefault');
            jQuery(this).val(jQuery(this)[0].title);
        }
    });
    jQuery('.friend_del').live('click', function(e) {
        e.preventDefault();
        var friend_id = jQuery(this).children('a').attr('friend_id');
        var user_id = jQuery(this).children('a').attr('user_id');
        var div_friend = jQuery(this).parents('.user_friend');
        div_friend.css('opacity', '0.2');
        div_friend.load('/friendremove', {
            user_id: user_id,
            friend_id: friend_id
        }, function() {
            div_friend.removeClass('user_album');
            div_friend.fadeOut();
        });
    });
    jQuery('.user_friend').live('mouseout', function(e) {
        jQuery(this).children('.object_del').hide();
    });
    jQuery('.user_friend').live('mouseover', function(e) {
        jQuery(this).children('.object_del').show();
    });
    jQuery('.object_del').live('click', function(e) {
        e.preventDefault();
        var div_friend = jQuery(this).parents('.user_friend');
        div_friend.css('opacity', '0.2');
        div_friend.load(jQuery(this).children('a').attr('href'), function() {
            div_friend.removeClass('user_album');
            div_friend.fadeOut();
        });
    });
    jQuery('.deny').live('click', function(e) {
        e.preventDefault();
        var div_item = jQuery(this).parents('.request');
        div_item.css('background-color', '#CCCCCC');
        div_item.load(jQuery(this).attr('href'), function() {
            div_item.css('background-color', '#fff')
        });
    });
    jQuery('.approve').live('click', function(e) {
        e.preventDefault();
        var item_id = jQuery(this).attr('item_id');
        var id = jQuery(this).attr('id');
        var div_item = jQuery(this).parents('.request');
        div_item.css('background-color', '#CCCCCC');
        div_item.load(jQuery(this).attr('href'), {
            id: id,
            item_id: item_id
        }, function() {
            div_item.css('background-color', '#fff')
        });
    });
    jQuery('#user_status_button').live('click', function(e) {
        e.preventDefault();
        var user_status_element_new = jQuery('.user_status_element_new');
        jQuery('#user_status_box').css('background-color', '#CCCCCC');
        jQuery('.submit-row').hide();
        var userstatus = jQuery('#user_status_box').attr('value');
        user_status_element_new.load(jQuery('#user_status_form').attr('action'), {
            user_status: userstatus
        }, function() {
            user_status_element_new.fadeIn(), jQuery('#user_status_box').css('background-color', '#FFFFFF');
            jQuery('#user_status_box').val('');
            jQuery('.submit-row').show();
        });
        user_status_element_new.removeAttr('class');
        user_status_element_new.addClass('user_status');
        user_status_element_new.before('<div class="user_status_element_new"></div>');
    });
    jQuery('.delete_status>a').live('click', function(e) {
        e.preventDefault();
        var user_status = jQuery(this).parents('.user_status').fadeOut();
        var id = jQuery(this).attr('id');
        user_status.load(jQuery(this).attr('action'), {
            id: id
        }, function() {
            user_status.fadeIn();
        });
    });
    jQuery('.user_updates').live('click', function(e) {
        e.preventDefault();
        var action = jQuery(this).children('a').attr('href');
        jQuery(this).load(action, {}, function() {
            jQuery(this).removeClass('user_updates');
        });
    });
    jQuery('.delete_school>a').live('click', function(e) {
        e.preventDefault();
        var user_school_element = jQuery(this).parents('.user_school_element').fadeOut();
        var school_id = jQuery(this).attr('school_id');
        user_school_element.load('/deleteschool', {
            school_id: school_id
        }, function() {
            user_school_element.fadeIn();
        });
    });
    jQuery('.user_school_element').live('mouseout', function(e) {
        jQuery(this).children('.delete_school').hide();
    });
    jQuery('.user_school_element').live('mouseover', function(e) {
        jQuery(this).children('.delete_school').show();
    });
    jQuery('#friend_invite').click(function() {
        toggleCheckboxes('#friend_invite', 'markinvite', true);
    });
    jQuery('.photo_rating').live('mouseenter', function() {
        var alt = jQuery(this).attr('alt');
        jQuery('#popup-' + alt).show();
    });
    jQuery('.photo_rating').live('mouseout', function() {
        var alt = jQuery(this).attr('alt');
        jQuery('#popup-' + alt).hide();
    });
    jQuery('.sf_asset_action_add_file').click(function() {
        setInterval("jQuery.getJSON(\'/az/sfMediaLibrary/upload\', {progress_key:jQuery('#progress_key').attr('value')}, function JSON(json){jQuery(\'#progressbar\').show();jQuery(\'#progressbar\').reportprogress(eval(json.current/json.total*100));} )", 1000)
    });
    jQuery('.playButton_videolist>img').live('click', function(e) {
        e.preventDefault();
        if (jQuery(this).attr('class') == 'play_button_play') {
            jQuery('.play_button_stop').removeClass('play_button_stop').addClass('play_button_play');
            jQuery(this).removeClass('play_button_play').addClass('play_button_stop');
            video_id = jQuery(this).attr('video_id');
            videolist_id = jQuery(this).attr('videolist_id');
            jQuery('#loader_player').show();
            jQuery('#fmpsv_video_player').load('/playvideolist', {
                video_id: video_id,
                videolist_id: videolist_id
            }, function() {
                jQuery('#loader_player').hide();
            });
        } else if (jQuery(this).attr('class') == 'play_button_stop') {
            jQuery(this).removeClass('play_button_stop').addClass('play_button_play');
            jQuery('#fmpsv_video_player').load('/novideo', {});
        }
    });
    jQuery('.playButton>img').live('click', function(e) {
        e.preventDefault();
        if (jQuery(this).attr('class') == 'play_button_play') {
            jQuery('.play_button_stop').removeClass('play_button_stop').addClass('play_button_play');
            jQuery(this).removeClass('play_button_play').addClass('play_button_stop');
            video_id = jQuery(this).attr('video_id');
            jQuery('#loader_player').show();
            jQuery('#fmpsv_video_player').load('/playvideo', {
                video_id: video_id
            }, function() {
                jQuery('#loader_player').hide();
            });
        } else if (jQuery(this).attr('class') == 'play_button_stop') {
            jQuery(this).removeClass('play_button_stop').addClass('play_button_play');
            jQuery('#fmpsv_video_player').load('/novideo', {});
        }
    });
    jQuery('.addButton>img').live('click', function(e) {
        e.preventDefault();
        jQuery('#login').slideDown(1000);
    });
    jQuery('#video_search_form').submit(function(e) {
        e.preventDefault();
        jQuery('#loader').show();
        jQuery('#loader_bd').show();
        jQuery('#search_button').hide();
        jQuery('#itemsearchResults').css('opacity', '0.33');
        jQuery('#itemsearchResults').load(jQuery(this).attr('action'), {
            query: jQuery('#search_keywords').attr('value')
        }, function() {
            jQuery('#loader').hide();
            jQuery('#loader_bd').hide();
            jQuery('#search_button').show();
            jQuery('.selected').removeClass('selected');
            jQuery('#itemsearchResults').css('opacity', '1');
        });
    });
    jQuery('#user_status_box').live('focusin', function() {
        jQuery('.submit_status_link_button').show();
    }).live('focusout', function() {
        setTimeout(function() {
            jQuery('.submit_status_link_button').hide();
        }, 200);
    });
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
        var user_status_box = jQuery('#user_status_box').attr('value');
        var user_status_box_title = jQuery('#user_status_box').attr('title');
        if (user_status_box == user_status_box_title) user_status_box = '';
        if (user_status_box != '') {
            jQuery('#user_status_box').css('background-color', '#CCCCCC');
            jQuery('.submit_status_link_button').hide();
            user_status_element_new.load(jQuery('#user_status_form').attr('action'), {
                user_status: user_status_box
            }, function() {
                user_status_element_new.fadeIn(), jQuery('#user_status_box').css('background-color', '#FFFFFF');
                jQuery('#user_status_box').val('');
                jQuery('.submit_status_link_button').show();
            });
        } else {
            var post_link_text = jQuery('#post_link_text').attr('value');
            var post_link_text_title = jQuery('#post_link_text').attr('title');
            if (post_link_text == post_link_text_title) post_link_text = '';
            var link_title = jQuery('#atc_title').text();
            var link_desc = jQuery('#atc_desc').text();
            var link_url = jQuery('#atc_url').text();
            var no_thumb= jQuery('#no_thumb').is(':checked');
            var link_img_src = 0;
            if(!(no_thumb||(jQuery('#atc_images img').length==0)))
            {
              link_img_src = jQuery('#atc_images img[current]').attr('src');
            }
            user_status_element_new.load('links/postlink', {
                post_link_text: post_link_text,
                title: link_title,
                desc: link_desc,
                url: link_url,
                img_src: link_img_src
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
    jQuery('#attach').bind("click", parse_link);
    function parse_link() {
        var url = jQuery('#url').val();
        if (!url.match(/^[a-zA-Z]{1,5}:\/\//)) {
            url = 'http://' + url;
        }
        if (!isValidURL(url)) {
            alert('Please enter a valid url.');
            return false;
        } else {
            jQuery('#atc_loading').show();
            jQuery('#atc_url').html(url);
            jQuery.post("links/fetch?url=" + escape(url), {}, function(response) {
                jQuery('#atc_title').html(response.title);
                jQuery('#atc_desc').html(response.description);
                jQuery('#atc_price').html(response.price);
                jQuery('#atc_total_images').html(response.total_images);
                jQuery('#atc_images').html(' ');
                jQuery.each(response.images, function(a, b) {
                    jQuery('#atc_images').append('<img src="' + b + '" id="' + (a + 1) + '">');
                });
                jQuery('#atc_images img').hide();
                jQuery('#attach_content').fadeIn('slow');
                jQuery('#atc_loading').hide();
                jQuery('.post_link_text').show();
                jQuery('.submit_status_link_button').show();
                jQuery('#url').hide();
                jQuery('#attach').hide();
                var total_images = parseInt(jQuery('#atc_total_images').html());
                
                  jQuery('img#1').fadeIn().attr('current',1);
                  jQuery('#cur_image').val(1);
                  jQuery('#cur_image_num').html(1);
                  jQuery('#next').unbind('click');
                  jQuery('#next').bind("click", function() {
                    var total_images = parseInt(jQuery('#atc_total_images').html());
                    if (total_images > 0) {
                        var index = jQuery('#cur_image').val();
                        jQuery('img#' + index).hide().removeAttr('current');
                        if (index < total_images) {
                            new_index = parseInt(index) + parseInt(1);
                        } else {
                            new_index = 1;
                        }
                        jQuery('#cur_image').val(new_index);
                        jQuery('#cur_image_num').html(new_index);
                        jQuery('img#' + new_index).show().attr('current',1);
                    }
                });
                jQuery('#prev').unbind('click');
                jQuery('#prev').bind("click", function() {
                    var total_images = parseInt(jQuery('#atc_total_images').html());
                    if (total_images > 0) {
                        var index = jQuery('#cur_image').val();
                        jQuery('img#' + index).hide().removeAttr('current');
                        if (index > 1) {
                            new_index = parseInt(index) - parseInt(1);
                        } else {
                            new_index = total_images;
                        }
                        jQuery('#cur_image').val(new_index);
                        jQuery('#cur_image_num').html(new_index);
                        jQuery('img#' + new_index).show().attr('current',1);
                    }
                });
              
               if(total_images==0)
              {
                jQuery('#atc_total_image_nav').hide();
                jQuery('#atc_total_images_info').hide();
              }
              else
              {
                jQuery('#atc_total_image_nav').show();
                jQuery('#atc_total_images_info').show();
              }

             //end if total images
            });
        }
    };
//);
    jQuery('#photo_rating').raty();
    jQuery("textarea[class*=expand]").TextAreaExpander().live('focus', function(e) {
        jQuery('.submit-row').hide();
        jQuery(this).next().show();
    });
});
(function(jQuery) {
    jQuery.fn.TextAreaExpander = function(minHeight, maxHeight) {
        var hCheck = !(jQuery.browser.msie || jQuery.browser.opera);

        function ResizeTextarea(e) {
            e = e.target || e;
            var vlen = e.value.length,
                ewidth = e.offsetWidth;
            if (vlen != e.valLength || ewidth != e.boxWidth) {
                if (hCheck && (vlen < e.valLength || ewidth != e.boxWidth)) e.style.height = "24px";
                var h = Math.max(e.expandMin, Math.min(e.scrollHeight, e.expandMax));
                e.style.overflow = (e.scrollHeight > h ? "auto" : "hidden");
                e.style.height = h + "px";
                e.valLength = vlen;
                e.boxWidth = ewidth;
            }
            return true;
        };
        this.each(function() {
            if (this.nodeName.toLowerCase() != "textarea") return;
            var p = this.className.match(/expand(\d+)\-*(\d+)*/i);
            this.expandMin = minHeight || (p ? parseInt('0' + p[1], 10) : 0);
            this.expandMax = maxHeight || 99999;
            ResizeTextarea(this);
            if (!this.Initialized) {
                this.Initialized = true;
                jQuery(this).css("padding-top", 0).css("padding-bottom", 0);
                jQuery(this).bind("keyup", ResizeTextarea);
            }
        });
        return this;
    };
})(jQuery);
(function(jQuery) {
    jQuery.fn.raty = function(settings) {
        options = jQuery.extend({}, jQuery.fn.raty.defaults, settings);
        if (this.attr('id') === undefined) {
            debug('Invalid selector!');
            return;
        }
        var start = jQuery('#photo_rating').attr('rate');
        var read_only = jQuery('#photo_rating').attr('read_only');
        options.readOnly = read_only;
        options.start = start;
        $this = jQuery(this);
        if (options.number > 30) {
            options.number = 30;
        }
        if (options.path.substring(options.path.length - 1, options.path.length) != '/') {
            options.path += '/';
        }
        var containerId = $this.attr('id');
        var path = options.path;
        var starOff = options.starOff;
        var starOn = options.starOn;
        var onClick = options.onClick;
        var photo_id = jQuery(this).attr('photo_id');
        var start = 0;
        if (!isNaN(options.start) && options.start > 0) {
            start = (options.start > options.number) ? options.number : options.start;
        }
        var hint = '';
        for (var i = 1; i <= options.number; i++) {
            hint = (options.number <= options.hintList.length && options.hintList[i - 1] !== null) ? options.hintList[i - 1] : i;
            starFile = (start >= i) ? options.starOn : options.starOff;
            $this.append('<img id="' + containerId + '-' + i + '" src="' + options.path + starFile + '" alt="' + i + '" class="' + containerId + '"/>').append((i < options.number) ? ' ' : '');
        }
        $this.css('width', options.number * 20).append('<input id="' + containerId + '-score" type="hidden" name="' + options.scoreName + '"/>');
        jQuery('#' + containerId + '-score').val(start);
        if (!options.readOnly) {
            jQuery('img.' + containerId).live('mouseenter', function() {
                var qtyStar = jQuery('img.' + containerId).length;
                if (!options.readOnly) {
                    for (var i = 1; i <= qtyStar; i++) {
                        if (i <= this.alt) {
                            jQuery('img#' + containerId + '-' + i).attr('src', path + starOn);
                        } else {
                            jQuery('img#' + containerId + '-' + i).attr('src', path + starOff);
                        }
                    }
                }
            });
            jQuery('img.' + containerId).live('click', function() {
                jQuery('input#' + containerId + '-score').val(this.alt);
                options.readOnly = 1;
                jQuery.ajax({
                    url: "/rate",
                    data: ({
                        photo_id: photo_id,
                        rate: this.alt
                    })
                });
                if (onClick) {
                    onClick(this.alt);
                }
            });
            $this.live('mouseleave', function() {
                var qtyStar = jQuery('img.' + containerId).length;
                var score = jQuery('input#' + containerId + '-score').val();
                if (!options.readOnly) {
                    for (var i = 1; i <= qtyStar; i++) {
                        if (i <= score) {
                            jQuery('img#' + containerId + '-' + i).attr('src', path + starOn);
                        } else {
                            jQuery('img#' + containerId + '-' + i).attr('src', path + starOff);
                        }
                    }
                }
            }).css('cursor', 'pointer');
        } else {
            $this.css('cursor', 'default');
        }
        return $this;
    };
    jQuery.fn.raty.defaults = {
        hintList: ['bad', 'poor', 'regular', 'good', 'gorgeous'],
        number: 5,
        path: '/images',
        readOnly: false,
        scoreName: 'score',
        start: 0,
        starOff: 'star-off.png',
        starOn: 'star-on.png'
    };
    jQuery.fn.raty.readOnly = function(boo) {
        if (boo) {
            jQuery('img.' + $this.attr('id')).die();
            $this.css('cursor', 'default').die();
        } else {
            liveEnter();
            liveLeave();
            liveClick();
            $this.css('cursor', 'pointer');
        }
        return jQuery.fn.raty;
    };
    jQuery.fn.raty.start = function(start) {
        initialize(start);
        return jQuery.fn.raty;
    };
    jQuery.fn.raty.click = function(score) {
        var star = (score >= options.number) ? options.number : score;
        initialize(star);
        if (options.onClick) {
            options.onClick(star);
        } else {
            debug('You should add the "onClick: function() {}" option.');
        }
        return jQuery.fn.raty;
    };

    function liveEnter() {
        var id = $this.attr('id');
        jQuery('img.' + id).live('mouseenter', function() {
            var qtyStar = jQuery('img.' + id).length;
            for (var i = 1; i <= qtyStar; i++) {
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
        $this.live('mouseleave', function() {
            var qtyStar = jQuery('img.' + id).length;
            var score = jQuery('input#' + id + '-score').val();
            for (var i = 1; i <= qtyStar; i++) {
                if (i <= score) {
                    jQuery('img#' + id + '-' + i).attr('src', options.path + options.starOn);
                } else {
                    jQuery('img#' + id + '-' + i).attr('src', options.path + options.starOff);
                }
            }
        });
    };

    function liveClick() {
        alert('liveClick');
        var id = $this.attr('id');
        jQuery('img.' + id).live('click', function() {
            jQuery('input#' + id + '-score').val(this.alt);
            options.readOnly = true;
        });
    };

    function initialize(start) {
        var id = $this.attr('id');
        var qtyStar = jQuery('img.' + id).length;
        jQuery('input#' + id + '-score').val(start);
        for (var i = 1; i <= qtyStar; i++) {
            if (i <= start) {
                jQuery('img#' + id + '-' + i).attr('src', options.path + options.starOn);
            } else {
                jQuery('img#' + id + '-' + i).attr('src', options.path + options.starOff);
            }
        }
    };

    function debug(message) {
        if (window.console && window.console.log) {
            window.console.log(message);
        }
    };
})(jQuery);
(function(jQuery) {
    jQuery.fn.reportprogress = function(val, maxVal) {
        var max = 100;
        if (maxVal) max = maxVal;
        return this.each(function() {
            var div = jQuery(this);
            var innerdiv = div.find(".progress");
            if (innerdiv.length != 1) {
                innerdiv = jQuery("<div class='progress'></div>");
                div.append("<div class='text'> </div>");
                jQuery("<span class='text'> </span>").css("width", div.width()).appendTo(innerdiv);
                div.append(innerdiv);
            }
            var width = Math.round(val / max * 100);
            innerdiv.css("width", width + "%");
            div.find(".text").html(width + " %");
        });
    };
})(jQuery);

function isValidURL(url) {
    var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?\.[a-zA-Z]{2,4}$/;
    if (RegExp.test(url)) {
        return true;
    } else {
        return false;
    }
}
