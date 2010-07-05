<?php	
	// carrega o busca
	$busca = JRequest::getvar('q', '');

	// importa a class produtos
	jimport('edesktop.programas.produtos');

	// carrega
	$p = new edProdutos();
	
	// paginação
	$p->paginacao->por_pagina = $this->config->get('produtosPorPagina');
	
	// tipos de orders
	$p->paginacao->orders = array(
		array('label' => 'Preço', 'sql' => 'valor ASC'),
		array('label' => 'Nome', 'sql' => 'nome ASC')
	);
	
	// pega o sql order
	$order = $p->paginacao->get_order();
	
	// busca dados
	$dados = $p->busca_produtos_por_texto($busca, "AND status = '1'AND valor > 0 {$order}", array('fabricante', 'imagem'));
	
	// envia para o layout
	$this->assignRef('dados', $dados);
	
	// envia para o layout a paginação
	$this->assignRef('paginacao', $p->paginacao);
	
	// Altera o titulo
	$_SESSION['eload']['title'] = "{$busca} - Pesquisa {sitename}";

?>