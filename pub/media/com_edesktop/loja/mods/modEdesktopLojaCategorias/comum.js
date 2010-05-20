$(function(){
	
	// Menu categorias
	$("li", '.modEdesktopLojaCategorias').each(function(){								
		$(this).hover(function(){
			$('a:eq(0)', this).addClass('hover');
		}, function(){
			$('a:eq(0)', this).removeClass('hover');
		});
		
	});


	// Menu categorias
	$("li.pai", '.modEdesktopLojaCategorias').each(function(){
		var pai = $('ul:eq(0)', this);
										
		$(this).hover(function(){
			pai.show();
		}, function(){
			pai.hide();
		});
	});

});



