// carrega o form
var $form = $('form', $dialog);

// monta as tabs
$('.extras', $dialog).tabs();

// inicia a validação
$form.validaForm({ 
	success : function(params, $main){
						
		if(params.retorno == 'insertOk'){
			// adiciona o id no form
			var html = '<div class="line"><span>Código</span>'+ params.produto.id +'<input type="hidden" name="produto[id]" value="'+ params.produto.id +'" /><br class="clearfix"/></div>';
			$form.prepend(html);
			
			// textos
			var rel = "'pagina': 'textos.form', 'programa': 'produtos', 'processID': 'new', 'query': 'idproduto="+ params.produto.id +"'";
			$('#txt .add', $form).attr('rel', rel);			
		}		

		// exibe as abas
		$('.extras', $form).show();
		
		// atualiza o alias
		$('input.alias', $form).val(params.produto.alias);
				
		// desliga o loading
		eDesktop.dialog.loading.stop($main);		
	}
	
});


$('ul.lista li a', $dialog).each(function(){
	var $a = $(this);
	var $li = $a.parent();
	var i = $a.attr('rel');
		
	// add checkbox
	$li.prepend('<input type="checkbox" value="' +i+ '" name="categorias[]" />');
	
	// checkbox
	var $checkbox = $(':checkbox', $li);
	
	// event tag a
	$a.click(function(){ $checkbox.click(); });
});

// remove o style das listas
$('ul.lista, ul.lista * ul', $dialog).addClass('lsn');