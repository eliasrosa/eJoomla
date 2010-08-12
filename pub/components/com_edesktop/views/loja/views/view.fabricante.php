<?php
	// carrega o id ca categoria
	$id = JRequest::getInt('id', 0);

	// importa a class loja
	jimport('edesktop.programas.loja');

	// pega a config
	$config = edLoja::getInstance()->getConfig();

	// carrega dados
	$dados = edProdutos::getInstance()
				->setConfig($config)
				->busca_produtos_ativos_por_fabricante($id)
				->createPager();
	
	// envia para o layout
	$this->assignRef('dados', $dados);

	// abre o fabricante
	$fabricante = edProdutos::getInstance()
					->busca_fabricante_ativo_por_id($id)
					->fetchOne(array(), Doctrine_core::HYDRATE_ARRAY);
	if($fabricante)
	{
		$nome = $fabricante['nome'];
		$_SESSION['eload']['title'] = "{$nome} - {sitename}";
		$this->assignRef('titulo', $nome);
	}
?>