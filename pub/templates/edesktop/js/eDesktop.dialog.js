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
			$('<div id="d'+process.id+'" class="dialog" title="'+process.titulo+'"><div id="#' +process.programa+ '" class="conteudo programa"></div></div>').dialog({
				
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
			}
											
		},


		load : function(href, processID){
			
			var dados = href.replace(location.pathname, '').split('/', 2);
			
			// pasta do programa
			var programa = dados[0];
			
			// pagina do programa		
			var pagina = dados[1];
			
			// query string do programa
			var query = '';
			
			// verifica se exist a pagina
			if(pagina != undefined){
			
				// captura a pagina e a query string 
				dados = dados[1].split('?', 2);
				
				// pagina do programa		
				var pagina = dados[0];
				
				if(dados.length > 1){
					// query string do programa
					var query = dados[1];
				}
			
			}
					
			// verifica se o processo existe
			if(processID == "new"){
							
				// adiciona um novo processo
				eDesktop.process.add(programa, function(process)
				{							
					// adiciona icone no toolbar
					eDesktop.toolbar.add(process);
					
					// adiciona uma na caixa de dialog
					eDesktop.dialog.init(process);
					
					// carrega o conteudo da página
					eDesktop.dialog.conteudo(process.id, pagina, query);
				});										

			}else{
				
				// carrega o conteudo da página
				eDesktop.dialog.conteudo(processID, pagina, query);

			}
			
			
		},


		conteudo : function(processID, pagina, query){
						
			var process = eDesktop.process.get(processID);
			
			if(pagina == undefined)
				pagina = 'index';
						
			var params =  'programa=' +process.programa+ '&pagina=' +pagina+ '&processID=' +processID;
			
			if(query != '')
				params = params+ '&' +query;
			
			eDesktop.exec('programa', 'conteudo', params, function(html){	
				
				var $main = $('#d' +processID);
				var $conteudo = $('.conteudo', $main.parent());
				
				// zera o conteudo
				$conteudo.html('').append(html);
				
				// evento clink dos links
				$('a.link', $conteudo).click(function(){
					
					// captura o programa
					var href = $(this).attr('href');
					var target = $(this).attr('target');
					
					//													
					processID = (target == "new") ? "new" : processID;
															
					// inicia eventos e procedimento para as caixas de dialogo
					eDesktop.dialog.load(href, processID);
					
					return false;		
				});
							
			}, 'html');
			
		}	
		
	};	
});
