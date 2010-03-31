$(function(){
		
	$('#login').dialog({
		autoOpen : true,
		modal: true,
		closeOnEscape: false,
		title: "Área Restrita"
	});
	
	$('#login input:submit').button();
		
});
