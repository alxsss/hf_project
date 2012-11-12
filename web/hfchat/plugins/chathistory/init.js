<?php
		if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."lang/".$lang.".php")) {
			include dirname(__FILE__).DIRECTORY_SEPARATOR."lang/".$lang.".php";
		} else {
			include dirname(__FILE__).DIRECTORY_SEPARATOR."lang/en.php";
		}
?>
(function($){   
  
	$.ccchathistory = (function () {

		var title = '<?php echo $chathistory_language[0];?>';

        return {

			getTitle: function() {
				return title;	
			},

			init: function (id) {
				baseUrl = $.hfchat.getBaseUrl();
				window.open (baseUrl+'plugins/chathistory/index.php?history='+id, 'chathistory',"status=0,toolbar=0,menubar=0,directories=0,resizable=0,location=0,status=0,scrollbars=1, width=600,height=500"); 
			}

        };
    })();
 
})(jqcc);