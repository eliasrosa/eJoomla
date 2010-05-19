$(function(){
	var $form = $('#loja-cadastro form.cadastro');
	

	$form.validaForm({
		success: function(){
			return true;			
		},
		upload: false
	 });

	// finalizar compra
	$('a.finalizarCompra', $form).click(function(){
		$form.submit();
	});	
	
	
	$('textarea.anot', $form).keyup(function(){
		var limit = 250;
		var text = $(this).val();
		
		if(limit < text.length){

			var v = text.substr(0, limit);
			$(this).val(v);
				
			return false;
		}
		
		$('span.limit', $form).html('limite: '+ (limit - text.length) );
		return true;
	}).keyup();

});



