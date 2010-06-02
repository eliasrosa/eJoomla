<?
	$menu_principal = new menu_lateral('Menu principal');
	$menu_principal->add('Listar todos produtos', 'produtos.lista');	
	$menu_principal->add('Cadastro de produto', 'produtos.form');
	$menu_principal->add('Listar todas categorias', 'categorias.lista');
	$menu_principal->add('Cadastro de categoria', 'categorias.form');

