<?php
	// importa a class de categorias de produtos
	jimport('edesktop.programas.produtos.categorias');

	$cat = new edesktop_produtos_categorias();
	
	// paginação
	$produtos->paginacao = $this->config->get('produtosPorPagina');
	
	// carrega o id ca categoria
	$id = JRequest::getvar('id', 0);
	
	// carrega ids das categorias filhas
	$ids = $cat->busca_ids($id);
	
	// busca dados
	$dados = $produtos->busca_por_categorias($ids);

	// envia para o layout
	$this->assignRef('dados', $dados);
	
	// envia para o layout a paginação
	$this->assignRef('paginacao', $produtos->paginacao);

	// abre a categoria
	$cat = $cat->busca_por_id($id);
	
	// Altera o titulo
	$_SESSION['eload']['title'] = "{$cat->nome} - {sitename}";
?>