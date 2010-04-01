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
	
	window.confirm_test = function(msg){
		
		var bool = '';
		var html = '<div id="dialog-confirm" title="Atenção"><p>'+ msg +'</p></div>';
		
		$(html).dialog({
			closeOnEscape: false,
			modal: true,
			buttons: {
				Cancelar : function() {
					$(this).dialog('close');
					$(this).dialog('destroy');
					return false;
				},
				OK : function(a) {
					$(this).dialog('close');
					$(this).dialog('destroy');
					return true;
				}
			}
		});
	
		
	};		

});
