// carrega o form
var $form = $('form', $dialog);

// monta as tabs
$('.extras', $dialog).tabs();

// inicia a validação
$form.validaForm({ 
	success : function(params, $main){
		
		if(params.tipo == 'highlight'){		
			// recarrega a pagina							
			eDesktop.dialog.load({
				'processID': processID,
				'pagina': pagina,
				'query': 'msg=' +params.msg+ '&msg_tipo=' +params.tipo+ '&id=' +params.produto.id
			});
			
			return;
		}
		
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