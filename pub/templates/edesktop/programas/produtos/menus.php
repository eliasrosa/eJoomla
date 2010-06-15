<?
	$menu_principal = new menu_lateral('Menu principal');
	$menu_principal->add('Listar todos produtos', 'produtos.lista');	
	$menu_principal->add('Cadastro de produto', 'produtos.form');
	$menu_principal->add('Listar todas categorias', 'categorias.lista');
	$menu_principal->add('Cadastro de categoria', 'categorias.form');

	$idproduto = JRequest::getvar('idproduto', 0);
	
	$menu_imagens = new menu_lateral('Imagens', 1);
	$menu_imagens->add('Cadastro', array('pagina' => 'imagens.form', 'query' => "idproduto={$idproduto}"));	
	$menu_imagens->add('Listar imagens', array('pagina' => 'imagens.lista', 'query' => "idproduto={$idproduto}"));	
