$(function(){

	/* alert custon
	***********************************************************/	
	window.alert = function(msg){
	
		var html = '<div id="dialog-alert" title="Atenção"><p>'+ msg +'</p></div>';
		
		$(html).dialog({
			closeOnEscape: false,
			modal: true,
			buttons: {
				Ok: function() {
					$(this).dialog('close');
				}
			}
		});
		
	};	

});
