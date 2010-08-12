<?php	
	// carrega o busca
	$busca = JRequest::getvar('q', '');

	// importa a class loja
	jimport('edesktop.programas.loja');

	// pega a config
	$config = edLoja::getInstance()->getConfig();

	// carrega dados
	$dados = edProdutos::getInstance()
				->setConfig($config)
				->busca_produtos_ativos_por_search($busca)
				->createPager();
	
	// envia para o layout
	$this->assignRef('dados', $dados);
	
	// Altera o titulo
	$_SESSION['eload']['title'] = "Resultado da busca: {$busca} - {sitename}";

?>