$(function(){
	var $form = $('#loja-produto .produto .dados form');
	
	$form.validaForm({
		success: function(){
			return true;			
		},
		upload: false
	 });

});



