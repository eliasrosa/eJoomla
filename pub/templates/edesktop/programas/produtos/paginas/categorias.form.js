// carrega o form
var $form = $('form', $dialog);

// inicia a validação
$form.validaForm({ 
	success : function(params, $main){
		
		console.log(params);		
		
		if(params.retorno == 'insertOk'){
			// adiciona o id no form
			var html = '<input type="hidden" name="categoria[id]" value="'+ params.id +'" />';
			$form.prepend(html);			
		}		
				
		// desliga o loading
		eDesktop.dialog.loading.stop($main);		
	}
	
});
