$(function(){
	var $shop = $('#loja-carrinho form');
	
	// remover
	$('a.rm', $shop).click(function(){
		var classe = $(this).attr('rel');
		$('input.' +classe, $shop).val(0);
		$('.funcao', $shop).val('update');
		$shop.submit();
	});
	

	// atualizar
	$('a.up', $shop).click(function(){
		$('.funcao', $shop).val('update');		
		$shop.submit();
	});
	

	// atualizar
	$('a.cupom', $shop).click(function(){
		$('.funcao', $shop).val('cupom');	
		$shop.submit();
	});
	
		
	// frete
	$('a.cep', $shop).click(function(){
		$('.funcao', $shop).val('cep');
		$shop.submit();
	});	
	
	
	// tipo frete
	$('.frete .tipos input', $shop).change(function(){
		$('.funcao', $shop).val('update');	
		$shop.submit();
	});	
	
	

});