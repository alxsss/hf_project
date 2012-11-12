<?php
		if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."lang/".$lang.".php")) {
			include dirname(__FILE__).DIRECTORY_SEPARATOR."lang/".$lang.".php";
		} else {
			include dirname(__FILE__).DIRECTORY_SEPARATOR."lang/en.php";
		}
?>
(function($){   
  
	$.ccchattime = (function () {

		var title = '<?php echo $chattime_language[0];?>';

        return {

			getTitle: function() {
				return title;	
			},

			init: function (id) {

				if ($("#hfchat_user_"+id+"_popup .hfchat_ts").css('display') == 'none') {
					$("#hfchat_user_"+id+"_popup .hfchat_ts").css('display','inline');
					$("#hfchat_tabcontenttext_"+id).scrollTop(50000);
				} else {
					$("#hfchat_user_"+id+"_popup .hfchat_ts_date").css('display','none');
					$("#hfchat_user_"+id+"_popup .hfchat_ts").css('display','none');					
				}
			}

        };
    })();
 
})(jqcc);