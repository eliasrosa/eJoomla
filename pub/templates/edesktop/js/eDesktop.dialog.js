$(function(){
	
	/* eDesktop - Dialog
	***********************************************************/
	eDesktop.dialog = {
		
		position : {
			x : 200,
			y : 80,
			d : 30
		},		
		
		init : function(process){
						
			// carrega o process para global
			this.process = process;
						
			// organiza as janelas na posição cascata			
			this.position.x = this.position.x + this.position.d;
			this.position.y = this.position.y + this.position.d;

			// cria a caixa de dialog
			$('<div id="d'+process.id+'" class="dialog" title="'+process.titulo+'"><div class="finder-result"><h1>Resultado da pesquisa em ' +process.titulo+ '</h1><div class="result"></div><a href="javascript:void(0);" class="fechar">Fechar pesquisa</a></div><div id="' +process.programa+ '" class="conteudo"></div></div>').dialog({
				
				close: function(event, ui){
					$('#toolbar label[for="t'+process.id+'"]').remove();
					$('#toolbar input[id="t'+process.id+'"]').remove();
					$(this).remove();
				}, 
				hide : 'drop',
				position: [this.position.x, this.position.y],
				closeOnEscape: false,
				minWidth: 700,
				minHeight: 500,
				width: 700,				
				height: 500
			});
			
			var $main = this.$main = $('#d'+process.id);
			var $dialog = this.$dialog = $main.parent();
			
			// remove o arrendondamento do titulo
			$('.ui-dialog-titlebar ', $dialog).removeClass('ui-corner-all').addClass('ui-corner-top');
			
			// adiciona o icone no titulo do dialog
			$('span.ui-dialog-title', $dialog).prepend('<img src="' +eDesktop.url+ '/programas/' +process.programa+ '/_img/icone.png" width="16" />');
			
			// adiciona finder
			if(process.finder){
				$($dialog).append('<div class="finder ui-widget-content ui-corner-all"><span class="icone ui-icon ui-icon-search"></span><input type="text" class="" value="Pesquisar ' +process.titulo+ '" /></div>');
				
				// event press enter
				$('.finder input', $dialog).keypress(function(e){
					var code = (e.keyCode ? e.keyCode : e.which);
					var val  = $(this).val();
					
					if (code == 13 & val != ''){
						var query = 'finder=' +val ;
						eDesktop.dialog.conteudo(process.id, 'finder', query, '.finder-result .result');
						
						$('#' +process.programa+ '.conteudo', $dialog).hide();
						$('.finder-result', $dialog).show();
					}
				});
				
				$('.finder-result a.fechar', $dialog).click(function(){
					$('.finder-result', $dialog).hide();
					$('#' +process.programa+ '.conteudo', $dialog).show();
				}).button();
				
				//
				$('.finder input', $dialog).focus(function(){
					if($(this).val() == 'Pesquisar ' +process.titulo)
						$(this).val('');
				});
				
				//
				$('.finder input', $dialog).blur(function(){
					if($(this).val() == '')
						$(this).val('Pesquisar ' +process.titulo);
				});
				
			}
											
		},


		load : function(params){
						
			op = $.extend({
				programa: undefined,
				pagina: undefined,
				query: '',
				processID: undefined,
				options : {}
			}, params);
					
			//console.log(op);		
								
			// verifica se o processo existe
			if(op.processID == "new"){
							
				// adiciona um novo processo
				eDesktop.process.add(op.programa, function(process)
				{							
					// adiciona icone no toolbar
					eDesktop.toolbar.add(process);
					
					// adiciona uma na caixa de dialog
					eDesktop.dialog.init(process);
					
					// carrega o conteudo da página
					eDesktop.dialog.conteudo(process.id, op.pagina, op.query);
				});										

			}else{
				
				// carrega o conteudo da página
				eDesktop.dialog.conteudo(op.processID, op.pagina, op.query);

			}
			
			
		},


		conteudo : function(processID, pagina, query, target){
						
			var process = eDesktop.process.get(processID);
			
			var target = (target == undefined) ? '.conteudo' : target;
			
			var pagina = (pagina == undefined) ? 'index' : pagina;
						
			var params =  'programa=' +process.programa+ '&pagina=' +pagina+ '&processID=' +processID;
			
			if(query != '')
				params = params+ '&' +query;
			
			eDesktop.exec('programa', 'conteudo', params, function(html){	
				
				var $main = $('#d' +processID);
				var $conteudo = $(target, $main.parent());
				
				// zera o conteudo
				$conteudo.html('').append(html);
				
				// evento clink dos links
				$('a.link', $conteudo).click(function(){
					
					// captura os parametros
					var params = eval('(' +$(this).attr('rel')+ ')');

					// corrige o processID
					params.processID = (params.processID == "new") ? "new" : processID;
															
					// inicia eventos e procedimento para as caixas de dialogo
					eDesktop.dialog.load(params);
					
					return false;		
				});
							
			}, 'html');
			
		}	
		
	};
	
	window.load = eDesktop.dialog.load;	
});
