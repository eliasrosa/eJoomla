$(function(){
	
	/* eDesktop
	***********************************************************/
	$.extend(eDesktop, {
				
		load : {
			
			js : function(url) {
				var s = document.createElement("script");
				
				url = eDesktop.url + '/js/' + url;				
				
				s.setAttribute('type', 'text/javascript');
				s.setAttribute('src', url);
				var head = document.getElementsByTagName("head")[0];
				head.appendChild(s);
			},

			css : function(url) {
				var s = document.createElement("link");
				
				url = eDesktop.url + '/css/' + url;	
				
				s.setAttribute('rel', 'stylesheet');
				s.setAttribute('type', 'text/css');
				s.setAttribute('href', url);
				var head = document.getElementsByTagName("head")[0];
				head.appendChild(s);
			}
		},
		
		loading : {
		
			start : function(text){
				var css0 = { left: 0, zIndex: 9998, backgroundColor: '#FFF', height: $(document).height()+'px', width: '100%', opacity: 0, position: 'absolute' };
				var cssl = { backgroundColor: '#F1D254', left: '50%', zIndex: 9999, textAlign: 'center', width: '90px', marginLeft: '-45px', padding: '5px', color: '#222', fontWeight: 'bold', position: 'fixed' };
				
				if(text == undefined){
					text = 'Carregando...';
				}
				
				$('body').prepend('<div id="loading_bg"></div><div id="loading">'+text+'</div>');
				
				$('#loading_bg').css(css0);
				$('#loading').css(cssl);
			},
			
			stop : function(){
				$('#loading_bg, #loading').remove();
			}
		},
		
		exec : function(classs, method, params, callback, dataType){
			
			if(dataType == undefined)
				dataType = 'json';
			
			$.ajax({
				type: 'POST',
				url: 'index.php',
				data: 'template=' +eDesktop.template+ '&class=' +classs+ '&method=' +method+ '&' +params,
				dataType: dataType,
				success: function(a){
					callback(a);
				}
			});
			
		},		
				
	});
	
	
	eDesktop.load.css('init.css');
	
	eDesktop.load.js('eDesktop.functions.js');
	eDesktop.load.js('eDesktop.dialog.js');
	eDesktop.load.js('eDesktop.toolbar.js');
	eDesktop.load.js('eDesktop.process.js');
	eDesktop.load.js('eDesktop.interface.js');

	
});
