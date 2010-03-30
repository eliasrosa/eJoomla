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
			$('<div id="d'+process.id+'" class="dialog" title="'+process.titulo+'"><div class="menu"></div><div class="conteudo"></div></div>').dialog({
				
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


		load : function(programa, target, pagina, processID){
			if(target == 'new'){
				// adiciona um novo processo
				eDesktop.process.add(programa, function(process)
				{							
					// adiciona icone no toolbar
					eDesktop.toolbar.add(process);
					
					// adiciona uma na caixa de dialog
					eDesktop.dialog.init(process);
										
					// carrega o conteudo da página
					eDesktop.dialog.carregar_conteudo(process.id, pagina, 'main');					
				});										
			}
							
			if(target == 'conteudo' || target == 'main'){				
				// carrega o conteudo da página
				eDesktop.dialog.carregar_conteudo(processID, pagina, target);			
			}
		},



		carregar_conteudo : function(processID, pagina, target){
						
			var process = eDesktop.process.get(processID);
			if(pagina == undefined)
				pagina = process.default;
						
			var params =  'programa=' +process.programa+ '&pagina=' +pagina;
			eDesktop.exec('programa', 'dialog', params, function(html){	
				
				var $main = $('#d' +processID);
				var $menu = $('.menu', $main);
				var $conteudo = $('.conteudo', $main.parent());
				
				// zera o conteudo
				$conteudo.html('');	
				
				console.log(processID);
												
				// adicionda o titulo da pagina
				$conteudo.append('<h1>' + process.paginas[pagina].label+ '</h1>');
			
				// adicionda a descrição da pagina caso exista
				$conteudo.append('<p>' +process.paginas[pagina].descricao+ '</p>');
			
				// conteudo html
				$conteudo.append(html);					
			
				// carrega o menu		
				eDesktop.dialog.menu(process, pagina);
				
			}, 'html');

			
		},

		menu : function(process, pagina){
			
			// carrega o menu
			var $menu = this.$menu = $('.menu', this.$main);
			
			if(process.paginas[pagina].menu){
				// limpa o menu
				$menu.html('');
											
				// adiciona o titulo no menu
				var titulo = '<p>' +this.process.titulo+ '</p>';
				$menu.append(titulo);
				
				// adiciona os itens de menu
				$.each(process.paginas, function(a, b){
									
					var item = '<a href="javascript:void(0);" pagina="' +a+ '" target="' +b.target+ '" class="' +a+ '" programa="' + eDesktop.dialog.process.programa+ '" processID="' + eDesktop.dialog.process.id+ '">' +b.label+ '</a>';
					$menu.append(item);

					$('.'+a, $menu).click(function(){
						
						var programa = $(this).attr('programa');
						var processID = $(this).attr('processID');
						var target = $(this).attr('target');
						var pagina = $(this).attr('pagina');					

						// ativa o link
						if(target != 'new'){
							// remove o link ativo
							$('a', $menu).removeClass('ativo');
						
							// adiciona a class
							$(this).addClass('ativo');
						}
											
						eDesktop.dialog.load(programa, target, pagina, processID);
						
						return false;
						
					}).prepend('<span class="ui-icon ui-icon-bullet"></span>');
					
					if(a == pagina)
						$('.'+a, $menu).addClass('ativo');
					
				});
			}else{
				$menu.hide();
			}
							
		}		
		
		
	};	
});
