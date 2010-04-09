<?
	$menu_principal = new menu_lateral("Menu principal");
	$menu_principal->add('Adminstrar usuários', 'usuarios.lista');
	$menu_principal->add('Administrar grupos', 'grupos.lista');
	
	$menu_usuarios = new menu_lateral("Adminstrar usuários", true);
	$menu_usuarios->add('Listar todos', 'usuarios.lista');	
	$menu_usuarios->add('Adicionar', 'usuarios.add');

	$menu_grupos = new menu_lateral("Adminstrar grupos", true);
	$menu_grupos->add('Listar todos', 'grupos.lista');	
	$menu_grupos->add('Adicionar', 'grupos.add');
?>
