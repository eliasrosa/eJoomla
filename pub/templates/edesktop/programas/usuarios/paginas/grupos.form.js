// carrega o form
var $form = $('form', $dialog);

// inicia a validação
$form.validaForm({ 
	success : function(params, $main){
			
			
		if(params.retorno == 'insertOk'){
			// adiciona o id no form
			var html = '<input type="hidden" name="id" value="' +params.id+ '" />';
			$form.append(html);
		}		
				
		// desliga o loading
		eDesktop.dialog.loading.stop($main);		
	}
	
});



/* permissoes
 **************************/
$('a.todos', $form).click(function(){
	var a = $(this).parents('div.acessos');
	$(':checkbox', a).attr('checked', 'checked');
});


$('a.nenhum', $form).click(function(){
	var a = $(this).parents('div.acessos');
	$(':checkbox', a).removeAttr('checked');
});