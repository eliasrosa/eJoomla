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

});
