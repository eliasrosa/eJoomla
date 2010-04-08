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
		
		exec : function(classs, method, params, callback, dataType){
			
			if(dataType == undefined)
				dataType = 'json';
						
			$.ajax({
				type: 'POST',
				url: 'index.php',
				data: eDesktop.token+ '=1&' + 'template=' +eDesktop.template+ '&class=' +classs+ '&method=' +method+ '&' +params,
				dataType: dataType,
				success: function(a){
					callback(a);
				}
			});
			
		},		
				
	});
	

	window.LoadBar = function(){  
		this.value = 0;  
		this.sources = Array();  
		this.sourcesDB = Array();  
		this.totalFiles = 0;  
		this.loadedFiles = 0;  
	};  

	LoadBar.prototype.addScript = function(source){  
		this.totalFiles++;  
		this.sources[source] = source;  
		this.sourcesDB.push(source);  
	}; 
	
	LoadBar.prototype.show = function(){
		$('body').append('<div id="loadBar"><p>Carregando...<span>0%</span></p><div class="bar"></div></div>');
		$('#loadBar').css({ width: $(window).width(), height: $(window).height()});
		$('#loadBar .bar').progressbar();
	}
	
	LoadBar.prototype.run = function(){
		this.show();
		var i;
		for (i=0; i<this.sourcesDB.length; i++){
			var source = this.sourcesDB[i];
			var head = document.getElementsByTagName("head")[0];
			var script = document.createElement("script");
			script.type = "text/javascript";
			script.src = eDesktop.url+ "/js/" + source
			head.appendChild(script);
		}
	};
	
	LoadBar.prototype.setValue = function(i){
		$('#loadBar .bar').progressbar({ value: i});
		$('#loadBar p span').html(parseInt(i)+ '%');
	};
	
	LoadBar.prototype.loaded = function(file) {
		this.loadedFiles++;
		delete this.sources[file];
		var pc = (this.loadedFiles * 100) / this.totalFiles;
		this.setValue(pc);

		//Are all files loaded?
		if(this.loadedFiles == this.totalFiles){
			setTimeout(function(){
				$('#loadBar').fadeOut();
				window.onbeforeunload = function(){ return 'Todos os dados abertos serão perdidos!'; };
			}, 350);
		}
	};	
	

	myBar = new LoadBar();	
	myBar.addScript('eDesktop.functions.js');
	myBar.addScript('eDesktop.dialog.js');
	myBar.addScript('eDesktop.toolbar.js');
	myBar.addScript('eDesktop.process.js');
	myBar.addScript('eDesktop.interface.js');
	myBar.addScript('jquery.meio.mask.min.js');
	myBar.addScript('jquery.datepicker.js');
	myBar.addScript('jquery.validaform-1.0.13.js');
	myBar.run();
	
});
