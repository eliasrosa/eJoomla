	
	$('table tr.ui-widget-content:odd').addClass('bg2n');
	
	var $form = $('form', $dialog);
	
	$form.validaForm();
	
	$('table tr.ui-widget-content', $dialog).mouseenter(function(){
		$('.actions', this).css('visibility', 'visible');
	}).mouseleave(function(){
		$('.actions', this).css('visibility', 'hidden');
	});


	$('.actions .excluir a', $dialog).click(function(){
		if(confirm('Tem certeza que deseja remover este usuário?')){
			if(!confirm('Esta operação não poderá ser desfeita, deseja continuar?'))
				return false;
			else{
				// desmarca todos os checkbox
				$(':checkbox', $form).removeAttr('checked');
				
				// seleciona a linha
				var $tr = $(this).parents('tr');
				
				// marca o chekbox selecionado
				$tr.find(':checkbox').attr('checked', 'checked');
				
				// envia o form
				$form.submit();
				
				// executa form
				$tr.css('background', '#FF7145').fadeOut(1000, function(){
					// remove a linha
					$tr.remove();
					
					$('table tr.ui-widget-content').removeClass('bg2n');
					
					$('table tr.ui-widget-content:odd').addClass('bg2n');				
				});	
				
			}
		}else
			return false;
	});


	$('p.excluir a', $dialog).click(function(){
		if(confirm('Tem certeza que deseja remover este(s) usuário(s)?')){
			if(!confirm('Esta operação não poderá ser desfeita, deseja continuar?'))
				return false;
			else{
				// envia o form								
				$form.submit();
	
				// seleciona as linhas
				var $tr = $(':checked').parents('tr');						
				
				// executa o fadeOut
				$tr.css('background', '#FF7145').fadeOut(1000, function(){
					// Remove a linha
					$tr.remove();
					
					$('table tr.ui-widget-content').removeClass('bg2n');
					
					$('table tr.ui-widget-content:odd').addClass('bg2n');										
				});
			}
		}else
			return false;
	});
