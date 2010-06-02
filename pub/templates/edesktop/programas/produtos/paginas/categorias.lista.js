$('li a', $dialog).each(function(){
	var $a = $(this);
	var i = $a.attr('rel');
	var r = "'pagina': 'categorias.form', 'programa': 'produtos', 'query': 'id=" +i+ "'";
	
	// adicona a class link
	$a.addClass('link');
	
	// altera o atributo rel
	$a.attr('rel', r);
});

