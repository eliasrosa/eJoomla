setTimeout("myBar.loaded('eDesktop.progress.js')", 200);  

$(function(){
	
	/* eDesktop
	***********************************************************/
	eDesktop.process = {
		
		all : [],
					
		add : function(programa, callback){
			eDesktop.exec('process', 'add', 'programa=' + programa, function(p){		
				eDesktop.process.all[p.id] = p;
				callback(p);
			});
		},
		
		remove : function(id){
			
		},
		
		get : function(id){
			return eDesktop.process.all[id];
		}
		
	};	
	
});
