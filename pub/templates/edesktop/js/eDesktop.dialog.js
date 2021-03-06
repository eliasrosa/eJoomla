setTimeout("myBar.loaded('eDesktop.dialog.js')", 1300);  

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
			$('<div id="d'+process.id+'" class="dialog" title="'+process.titulo+'"><div class="main"><div id="' +process.programa+ '" class="conteudo"></div></div></div>').dialog({
				
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
				height: 500,
				resizable: false
			});
			
			var $main = this.$main = $('#d'+process.id);
			var $dialog = this.$dialog = $main.parent();
			
			// remove o arrendondamento do titulo
			$('.ui-dialog-titlebar ', $dialog).removeClass('ui-corner-all').addClass('ui-corner-top');
			
			// adiciona o icone no titulo do dialog
			$('span.ui-dialog-title', $dialog).prepend('<img src="' +eDesktop.url+ '/programas/' +process.programa+ '/_img/icone.png" width="16" />');
			
			// adiciona finder
			if(process.finder !== false){
				$($dialog).append('<div class="finder ui-widget-content ui-corner-all"><span class="icone ui-icon ui-icon-search"></span><input type="text" class="" value="Pesquisar em ' +process.titulo+ '" /></div>');
				
				// event press enter
				$('.finder input', $dialog).keypress(function(e){
					var code = (e.keyCode ? e.keyCode : e.which);
					var val  = $(this).val();
					
					if (code == 13 & val != ''){
						
						eDesktop.dialog.load({
							processID: process.id,
							programa: process.programa,
							pagina: process.finder,
							query: 'finder=' +val
						});
					}
				});
				
				$('.finder-result a.fechar', $dialog).click(function(){
					$('.finder-result', $dialog).hide();
					$('#' +process.programa+ '.conteudo', $dialog).show();
				}).button();
				
				//
				$('.finder input', $dialog).focus(function(){
					if($(this).val() == 'Pesquisar em ' +process.titulo)
						$(this).val('');
				});
				
				//
				$('.finder input', $dialog).blur(function(){
					if($(this).val() == '')
						$(this).val('Pesquisar em ' +process.titulo);
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


		conteudo : function(processID, pagina, query, options){

			var process = eDesktop.process.get(processID);
			var pagina = (pagina == undefined) ? 'index' : pagina;				
			var params =  'programa=' +process.programa+ '&pagina=' +pagina+ '&funcao=0&processID=' +processID;
			
			var $dialog = $('#d' +processID);
			
			var $conteudo = $('.conteudo', $dialog.parent());
			
			var $main = $('.main', $dialog.parent());
		
			params = (query == '') ? params : params+ '&' +query;
		
			var op = $.extend({
				
				callback : function(html){
					// zera o conteudo e adiciona o novo
					$conteudo.html('').append('<div class="corpo">' +html +'</div>');		
				}
				
			
			}, options);	
			
			
			eDesktop.dialog.loading.start($main);
			
			eDesktop.exec('programa', 'conteudo', params, function(html){	
								
				// executa a função
				op.callback(html);

				// evento clink dos links
				$('a.link', $dialog).click(function(){
					
					var rel = $(this).attr('rel');
					
					if(rel.substr(0, 1) != '{' && rel.substr(-1) != '}')
						rel = '{' +rel+ '}';
						
					// captura os parametros
					var params = eval('(' +rel+ ')');

					// corrige o processID
					params.processID = (params.processID == "new") ? "new" : processID;
															
					// inicia eventos e procedimento para as caixas de dialogo
					eDesktop.dialog.load(params);
					
					return false;		
				});	

				// carrega o menu
				var $menu = $('.menu_lateral', $dialog);
				
				// caso o menu exista
				if($menu.length)
					// move o menu
					$menu.prependTo($conteudo);
				else
					// corrige a largura
					$('.corpo', $dialog).width(670);

				// fecha o loader
				eDesktop.dialog.loading.stop($main);
							
			}, 'html');
			
		},

		loading : {
		
			start : function($obj){
				
				$obj.fadeOut();					
				
				var css = { right: 10, top: 10, position: 'absolute' };
				$('<div class="loading"><img src="' +eDesktop.url+ '/img/loading.gif"</div>').insertBefore($obj).css(css);
			},
			
			stop : function($obj){
				
				$('.loading', $obj.parent()).fadeOut().remove();				
				
				$obj.fadeIn();
			}
		},
		
		aviso : function(msg, tipo, $target){
			
			// icone do aviso
			var icon = (tipo == 'error') ? 'alert' : 'info';

			//
			msg = msg.replace('\n', '<br>');

			// html dos avisos
			var aviso = $('<div class="alertas ui-state-' +tipo+ ' ui-corner-all">'+
							'<p><span class="ui-icon ui-icon-' +icon+ '"></span>' +msg+ '</p>'+
							'<p class="fechar"><a href="javascript:void(0);">Fechar aviso!</a></p>'+
						'</div>').show('slide');
			
	
			// leva o scroll para o top
			$target.scrollTop(-1);
		
			// adiciona o aviso no inicio
			var $aviso = $(aviso).prependTo($target);
			
			// exibe o aviso
			$aviso.show('slide', function(){								
				// adiciona o evento do fechar
				$('p.fechar a', $aviso).click(function(){
					// esconde e remove o aviso
					$aviso.hide('slide', function(){
							$aviso.remove();
					});	
				});
			});
			
		}
					
		
	};
	
	window.load = eDesktop.dialog.load;	
});
