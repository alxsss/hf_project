<?php
		if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."lang/".$lang.".php")) {
			include dirname(__FILE__).DIRECTORY_SEPARATOR."lang/".$lang.".php";
		} else {
			include dirname(__FILE__).DIRECTORY_SEPARATOR."lang/en.php";
		}
?>
(function($){   
  
	$.ccclearconversation = (function () {

		var title = '<?php echo $clearconversation_language[0];?>';

        return {

			getTitle: function() {
				return title;	
			},

			init: function (id) {
				if ($("#hfchat_user_"+id+"_popup .hfchat_tabcontenttext").html() != '') {
					baseUrl = $.hfchat.getBaseUrl();
					$.post(baseUrl+'plugins/clearconversation/index.php?action=clear', {clearid: id});
					$("#hfchat_user_"+id+"_popup .hfchat_tabcontenttext").html('');
				}
			}

        };
    })();
 
})(jqcc);