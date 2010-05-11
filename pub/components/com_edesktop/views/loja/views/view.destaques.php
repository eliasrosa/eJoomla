<?php
	
	// paginação
	$produtos->paginacao = $this->config->get('produtosPorPagina');
	
	// busca dados
	$dados = $produtos->busca_por_destaque();

	// envia para o layout os dados
	$this->assignRef('dados', $dados);
	
	// envia para o layout a paginação
	$this->assignRef('paginacao', $produtos->paginacao);
	
	// Altera o titulo
	$_SESSION['eload']['title'] = "Produtos em destaque - {sitename}";
?>