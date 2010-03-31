$(function(){
		
	var $login = $('#login').dialog({
		autoOpen : true,
		modal: true,
		closeOnEscape: false,
		title: "Área Restrita"
	});
	
	$('#login input:submit').button();
	
	$('a.ui-dialog-titlebar-close', $login.parent()).remove();
		
});
