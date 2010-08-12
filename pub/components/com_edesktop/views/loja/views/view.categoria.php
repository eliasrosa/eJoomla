<?php
	// carrega o id ca categoria
	$id = JRequest::getInt('id', 0);

	// importa a class loja
	jimport('edesktop.programas.loja');

	// pega a config
	$config = edLoja::getInstance()->getConfig();

	// pega a config
	$config = edLoja::getInstance()->getConfig();

	// carrega os dados
	$dados = edProdutos::getInstance()
				->setConfig($config)
				->busca_produtos_ativos_por_categoria($id)
				->createPager();
	
		
	// envia para o layout
	$this->assignRef('dados', $dados);

	// abre o fabricante
	$categoria = edProdutos::getInstance()
					->busca_categoria_ativa_por_id($id)
					->fetchOne(array(), Doctrine_core::HYDRATE_ARRAY);	
	if($categoria)
	{ 
		$nome = $categoria['nome'];
		$_SESSION['eload']['title'] = "{$nome} - {sitename}";
		$this->assignRef('titulo', $nome);
	}

?>