$(function(){
	
	/* eDesktop - Interface
	***********************************************************/
	eDesktop.interface = {
		create : function(){
			
			this.toolbar();
					
			this.desktop();
			
			this.icones();
			
		},
		
		toolbar : function(){
			var html = '<div id="toolbar"><div class="programas"></div></div>';
			$('body').append(html);
			
			// adiciona o botão de minimizar tudo
			eDesktop.toolbar.minimizeAll();
			
			// adiciona o botão 
			eDesktop.toolbar.logout();
			
			// adiciona a busca rápida
			eDesktop.toolbar.finder();
			
		},

		
		desktop : function(){
			var html = '<div id="desktop"></div>';
			$('body').append(html);
		},
		
		icones : function(){	
			
			eDesktop.exec('programa', 'get_list', '', function(icones){		
				
				
				// adiciona os icones
				$.each(icones, function(i, p){
					var html = '<a class="icone" href="' +p.programa+ '"><img src="' +eDesktop.url+ '/programas/' +p.programa+ '/_img/icone.png" /><span>' +p.titulo+ '</span></a>';
					$('#desktop').append(html);		
				});

				
				
				/* desktop - height fix
				***********************************************************/	
				var hw = $(window).height();
				var ht = parseInt($('#desktop').offset().top) + parseInt($('#desktop').css('margin-top'));
				$('#desktop').height(hw - ht);
				

				
				/* auto alinhamento dos icones 
				***********************************************************/	
				var grd = { 'x' : 145, 'y' : 140};
				var row = Math.floor($('#desktop').height() / grd.x);
				var col = Math.ceil($('#desktop a.icone').length / row);
				var ix   = 0;
				var iy   = 0;
				
				$('#desktop a.icone.').each(function(i, icone){	
					iy++;
					if(iy > row){
						iy = 1;
						ix++;
					}
					
					var y = (iy - 1) * grd.y;
					var x = ix * grd.x;
					
					$(icone).css({ 'left' : x, 'top' : y, 'position': 'absolute'});			
				});
					


				/* adicona o evnto de drag
				***********************************************************/
				$('#desktop a.icone').draggable({
					start: function(){}, 
					stop: function(){}, 
					containment: '#desktop',
					scroll: false,
					revert: 'valid'
				}).droppable();				



				/* Busca rápida
				***********************************************************/	
				var programas = new Array();
				$('#desktop a.icone span').each(function(){
					programas.push($(this).html());
				});

				$('#busca-rapida').autocomplete({
					 minLength: 0,
					 source: programas
				});
	
	

				/* Abrir programa - evento de duplo click
				***********************************************************/
				$('#desktop a.icone').live('dblclick', function(){
					
					// captura o programa
					var href = $(this).attr('href');										
															
					// inicia eventos e procedimento para as caixas de dialogo
					eDesktop.dialog.load(href, 'new');

				}).click(function(){
					return false;
				});
				
				
			});		
		}
	};	
	
	// cria a inteface
	eDesktop.interface.create();
	
});
