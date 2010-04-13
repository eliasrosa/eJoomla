// carrega o form
var $form = $('form', $dialog);

// inicia a validação
$form.validaForm({ 
	success : function(params, $main){
			
		// limpa os campos de senhas
		$('form input[name="password"]', $main).val('');
		$('form input[name="password2"]', $main).val('');
			
			
		if(params.retorno == 'insertOk'){
			// adiciona o id no form
			var html = '<input type="hidden" name="id" value="' +params.id+ '" />';
			$form.append(html);
		}		
				
		// desliga o loading
		eDesktop.dialog.loading.stop($main);		
	}
	
});

// verifica se existe um option selecionado
if(!$('select[name="gid"]', $form).val())
	// seleciona o primeiro elemento
	$('select[name="gid"] option:first', $form).attr('selected', 'selected');
	
