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



// opções
var opcoes = {
	
	i : 0,

	init: function(){

		$('#opc .line .opNome', $form).keypress(function(e){
			var code = (e.keyCode ? e.keyCode : e.which);	
			if (code == 13){ 
				opcoes.add('', true);	
				return false;
			}
		});

		$('#opc a.opAdd', $form).click(function(){ 
			opcoes.add('', true);
		});

		this.load();
	},
	
	load: function(){
		
		var $opcoes = $('#opc', $form);
		var dados = eval($('.dados', $opcoes).html());
		
		$.each(dados, function(i, op){
			$op = opcoes.add(op.nome, false);

			$.each(op.itens, function(ii, item){
				opcoes.addItem(item, $op, opcoes.i);
			});
		});
	},
	
	add: function(n, autoAddItemEmpty){
		if(n == '')
			var n = $('#opc .line .opNome', $form).val();
		
		if (n != ''){
			this.i++;
			
			var html = '<fieldset class="op' +this.i+ '"><legend>' +n+ '</legend>' +
							'<input type="hidden" value="' +n+ '" name="opcoes[][' +this.i+ ']" />' +
							'<a href="javascript:void(0);" class="opAddItem">Adicionar opção</a> | ' +
							'<a href="javascript:void(0);" class="opRemove">Remover opção</a> | ' +
							'<a href="javascript:void(0);" class="opMover cmove">Mover</a>' +
							'<br class="clearfix" />' +							
						'</fieldset>';
						
			$('#opc .lista', $form).append(html);
			$('#opc .line .opNome', $form).val('');
		
			var $op = $('fieldset.op'+this.i, $form);
			var id = this.i; 
			
			$('.opAddItem', $op).click(function(){
				opcoes.addItem('', $op, id);
			})
			
			if(autoAddItemEmpty)
				$('.opAddItem', $op).click();
	
			$('.opRemove', $op).click(function(){
				$op.remove();
			});
			
			$('#opc .lista').sortable({
				items: 'fieldset',
				handle: '.opMover',
				cursor: 'move',
				containment: 'parent',
				placeholder: 'ui-state-highlight',
				forcePlaceholderSize: true
			});
			
			$op.sortable({
				items: 'p',
				handle: '.opItemMove',
				cursor: 'move',
				containment: 'parent',
				placeholder: 'ui-state-highlight',
				forcePlaceholderSize: true
			});
			
			return $op;

		}else{
			alert('Nome inválido!');
		}
	},
	
	addItem : function(txt, $op, i){
		
		var html = '<p>' +
						'<input type="text" class="w90 mr10" name="opcoes_itens[' +i+ '][]" value="' +txt+ '" />' +
						'<a href="javascript:void(0);" class="opItemMove cmove">Mover</a> | ' +
						'<a href="javascript:void(0);" class="opItemRemove">Remover</a>' +
					'</p>';
					
		$op.append(html);
		
		var $item = $('p:last-child', $op);
		
		$('.opItemRemove', $item).click(function(){
			$item.remove();
		});

		$('input', $item).keypress(function(e){
			var code = (e.keyCode ? e.keyCode : e.which);	
			var $i = $('p input[value=""]', $op);
			
			if (code == 13){ 
				if($i.length)
					$i.first().focus();
				else
					opcoes.addItem('', $op, i);
				return false;
			}
		}).focus();

		
	}
	
};

opcoes.init();
