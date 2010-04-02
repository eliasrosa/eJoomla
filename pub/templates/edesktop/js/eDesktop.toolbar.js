setTimeout("myBar.loaded('eDesktop.toolbar.js')", 1000);  

$(function(){
	
	/* eDesktop - Toolbar
	***********************************************************/

	eDesktop.toolbar = {
		add : function(p){
					
			var html = '<input type="checkbox" id="t'+p.id+'" class="check" /><label for="t'+p.id+'"><img src="' +eDesktop.url+ '/programas/'+p.programa+'/_img/icone.png" width="16" valign="bottom" />'+p.titulo+'</label>';			
			$('#toolbar .programas').append(html);

			$('#t'+p.id).button();
			
			$('#toolbar label[for="t'+p.id+'"]').click(function(b, c){
				$('#d'+p.id).dialog('moveToTop').parent().toggle('drop');
			});
		},
		
		minimizeAll : function(){
			
			var html = '<button id="minimizeAll" class="buttons">minimizeAll<button>';			
			$('#geral').prepend(html);
			
			$('#minimizeAll').button({
				text : false,
				icons : {
					primary : 'ui-icon-arrowthickstop-1-w'
				}
			});
			
			$('#minimizeAll').click(function(){
				$('#toolbar label.ui-button').each(function(a, b){;
					var e = $(b);
					if(!e.hasClass('ui-state-active'))
						e.click();
				});
			});			
		
		},
		
		logout : function(){
			
			var sair = function(){
				var alerta = confirm("Deseja realmente se desconectar do sistema?");					
				if(alerta){
					location.href = 'index.php?template=edesktop&logout=1';
					return true;
				}else
					return false;
			};
			
			var html = '<button id="logout" class="buttons">logout<button>';			
			$('#geral').prepend(html);
			
			$('#logout').button({
				text : false,
				icons : {
					primary : 'ui-icon-locked'
				}
			}).click(function(){
				sair();
			});	
			
		},		
		
		finder : function(){
			var html = '<div class="finder ui-widget-content ui-corner-all"><span class="icone ui-icon ui-icon-search"></span><input type="text" class="" value="Pesquisar" /></div>';
			$('#toolbar').append(html);
		}		
	};
		
});



