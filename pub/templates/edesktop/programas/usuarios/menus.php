<?
	$menu_principal = new menu_lateral('Menu principal');
	$menu_principal->add('Listar todos usuários', 'usuarios.lista');	
	$menu_principal->add('Cadastro de usuário', 'usuarios.form');
	$menu_principal->add('Administrar grupos de usuários', 'grupos.lista');
	
	$menu_grupos = new menu_lateral('Administrar grupos de usuários', true);
	$menu_grupos->add('Listar todos grupos', 'grupos.lista');	
	$menu_grupos->add('Adicionar novo grupo', 'grupos.form');
?>
