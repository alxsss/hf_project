(function($){   
  
	$.ccsmilies = (function () {

		var title = 'Send an emoticon';

        return {

			getTitle: function() {
				return title;	
			},

			init: function (id) {
				baseUrl = $.hfchat.getBaseUrl();
				window.open (baseUrl+'plugins/smilies/index.php?id='+id, 'smilies',"status=0,toolbar=0,menubar=0,directories=0,resizable=0,location=0,status=0,scrollbars=0, width=220,height=130"); 
			},

			addtext: function (id,text) {

				var string = $('#hfchat_user_'+id+'_popup .hfchat_textarea').val();
				
				if (string.charAt(string.length-1) == ' ') {
					$('#hfchat_user_'+id+'_popup .hfchat_textarea').val($('#hfchat_user_'+id+'_popup .hfchat_textarea').val()+text);
				} else {
					$('#hfchat_user_'+id+'_popup .hfchat_textarea').val($('#hfchat_user_'+id+'_popup .hfchat_textarea').val()+' '+text);
				}
				
				$('#hfchat_user_'+id+'_popup .hfchat_textarea').focus();
				
			}

        };
    })();
 
})(jqcc);