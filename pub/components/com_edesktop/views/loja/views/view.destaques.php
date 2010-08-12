<?php
	// importa a class loja
	jimport('edesktop.programas.loja');

	// pega a config
	$config = edLoja::getInstance()->getConfig();

	// carrega dados
	$dados = edProdutos::getInstance()
				->setConfig($config)
				->busca_produtos_ativos_por_destaque()
				->createPager();
	
	// envia para o layout
	$this->assignRef('dados', $dados);
		
	// Altera o titulo
	$_SESSION['eload']['title'] = "Produtos em destaque - {sitename}";
?>