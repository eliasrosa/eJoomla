// carrega o form
var $form = $('form', $dialog);

// add action
$form.attr('action', formURL('enviar_email.salvar'));

// inicia a validação
$form.validaForm({ 
	success : function(params, $main){
		
		if(params.retorno == true){		
			// recarrega a pagina							
			eDesktop.dialog.load({
				'processID': processID,
				'pagina': pagina,
				'query': 'msg=' +params.msg+ '&msg_tipo=' +params.tipo+ '&retorno=' +params.retorno+ '&id=' +params.id
			});
			
			return;
		}
		
		// desliga o loading
		eDesktop.dialog.loading.stop($main);
	}
});
