<?php
	// importa a class fabricantes
	jimport('edesktop.programas.produtos.fabricantes');

	// inicia no obj
	$produtos = new edesktop_produtos_produtos();

	// paginação
	$produtos->paginacao = $this->config->get('produtosPorPagina');
	
	// carrega o id
	$id = JRequest::getvar('id', 0);
	
	// busca dados
	$dados = $produtos->busca_por_fabricante($id);

	// envia para o layout
	$this->assignRef('dados', $dados);
	
	// envia para o layout a paginação
	$this->assignRef('paginacao', $produtos->paginacao);

	// inicia no obj
	$f = new edesktop_produtos_fabricantes();

	// abre o fabricante
	$f = $f->busca_por_id($id);
	
	// Altera o titulo
	$_SESSION['eload']['title'] = "{$f->nome} - {sitename}";

?>