<?php
	
	// paginação
	$produtos->paginacao = $this->config->get('produtosPorPagina');
	
	// carrega o busca
	$busca = JRequest::getvar('q', '');
	
	// busca dados
	$dados = $produtos->busca_por_texto($busca);

	// envia para o layout
	$this->assignRef('dados', $dados);
	
	// envia para o layout a paginação
	$this->assignRef('paginacao', $produtos->paginacao);
	
	// Altera o titulo
	$_SESSION['eload']['title'] = "{$busca} - Pesquisa {sitename}";
?>