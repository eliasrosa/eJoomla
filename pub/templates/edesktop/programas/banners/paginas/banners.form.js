// carrega o form
var $form = $('form', $dialog);

// inicia a validação
$form.validaForm({ 
	success : function(params, $main){
		
		if(params.tipo == 'highlight'){		
			// recarrega a pagina							
			eDesktop.dialog.load({
				'processID': processID,
				'pagina': pagina,
				'query': 'msg=' +params.msg+ '&msg_tipo=' +params.tipo+ '&id=' +params.id
			});
			
			return;
		}
		
		// desliga o loading
		eDesktop.dialog.loading.stop($main);
	}
});
