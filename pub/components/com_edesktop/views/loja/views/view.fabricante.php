<?php

	// importa a class produtos
	jimport('edesktop.programas.produtos');

	$p = new edProdutos();
	
	// paginação
	$p->paginacao->por_pagina = $this->config->get('produtosPorPagina');
	
	// carrega o id ca categoria
	$id = JRequest::getvar('id', 0);

	// tipos de orders
	$p->paginacao->orders = array(
		array('label' => 'Preço', 'sql' => 'valor ASC'),
		array('label' => 'Nome', 'sql' => 'nome ASC')
	);
	
	// pega o sql order
	$order = $p->paginacao->get_order();
	
	// busca dados
	$dados = $p->busca_produtos_por_fabricante($id, "AND status = '1' AND valor > 0 {$order}", array('fabricante', 'imagem'));
	
	// envia para o layout
	$this->assignRef('dados', $dados);
	
	// envia para o layout a paginação
	$this->assignRef('paginacao', $p->paginacao);

	// abre o fabricante
	$fabricante = $p->busca_fabricante_por_id($id);
	if($fabricante)
	{
		$nome = $fabricante->nome;
		$_SESSION['eload']['title'] = "{$nome} - {sitename}";
		$this->assignRef('titulo', $nome);
	}
?>