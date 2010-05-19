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
		
		var cep1 = $('.cep1:input', $shop).val();
		var cep2 = $('.cep2:input', $shop).val();
		var cep  = (cep1 + '-'+ cep2);
		
		if(/^\d{5}-\d{3}$/.test(cep)){
			$('.funcao', $shop).val('cep');
			$shop.submit();	
			return false;		
		}
			
		alert("CEP inválido!");
	});	
	
	// frete
	$('input.cep1', $shop).keyup(function(){
		var t = $(this).val().length;
		
		if(t == 5)
			$('input.cep2', $shop).select();
		
	});	

	// frete
	$('input.cep2', $shop).keyup(function(){
		var t = $(this).val().length;
		
		if(t == 3)
			$('a.cep', $shop).click();
			
	});	

	
	// tipo frete
	$('.frete .tipos input', $shop).change(function(){
		$('.funcao', $shop).val('update');	
		$shop.submit();
	});	
	
	
	// finalizar compra
	$('a.finalizarCompra', $shop).click(function(){
	
		$('.funcao', $shop).val('cadastro');	
		$shop.submit();
	
		/*	
		var token = $(':hidden[value="1"]', $shop).attr('name');

		$.ajax({
			type: "POST",
			url: $shop.attr('action'),
			cache: false,
			data: token+ "=1&funcao=cadastro" ,
			success: function(msg){
				alert();
			}
		});
		*/
	});	
	
	

});