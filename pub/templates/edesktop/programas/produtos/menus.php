<?
	$menu_principal = new menu_lateral('Menu principal');
	$menu_principal->add('Produtos', 'produtos.lista');	
	$menu_principal->add('Categorias', 'categorias.lista');
	
	$idproduto = JRequest::getvar('idproduto', 0);
	
	$menu_imagens = new menu_lateral('Imagens');
	$menu_imagens->add('Listar imagens', array('pagina' => 'imagens.lista', 'query' => "idproduto={$idproduto}"));	
	$menu_imagens->add('Cadastro', array('pagina' => 'imagens.form', 'query' => "idproduto={$idproduto}"));	

	$menu_textos = new menu_lateral('Textos');
	$menu_textos->add('Listar textos', array('pagina' => 'textos.lista', 'query' => "idproduto={$idproduto}"));	
	$menu_textos->add('Cadastro', array('pagina' => 'textos.form', 'query' => "idproduto={$idproduto}"));	
