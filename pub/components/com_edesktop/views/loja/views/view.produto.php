<?php
	// carrega o id do produto
	$id = JRequest::getvar('id', 0);

	// importa a class produtos
	jimport('edesktop.programas.produtos');

	$p = new edProdutos();

	// busca dados
	$dados = $p->busca_produto_por_id($id, "AND status = '1'", array(
		'fabricante', 'imagem', 'imagens', 'textos'
	));

	// remove imagem duplicada caso esteja em  destaque
	if($dados)
		foreach($dados->imagens as $k=>$i)
			if($dados->imagem->id == $i->id)
				unset($dados->imagens[$k]);

	// envia para o layout
	$this->assignRef('dados', $dados);

	if($dados)
	{
		// Description e keywords
		$doc =& JFactory::getDocument();
		$description = $dados->produto->metatagdescription ? $dados->produto->metatagdescription : $dados->produto->descricao;
		$description = substr(strip_tags($description), 0, 160);
		$doc->setMetaData('description', $description );
		$doc->setMetaData('keywords', $dados->produto->metatagkey);

		// Altera o titulo
		if($dados->produto->idfabricante)
			$_SESSION['eload']['title'] = "{$dados->produto->nome} - {$dados->fabricante->nome} - {sitename}";
		else
			$_SESSION['eload']['title'] = "{$dados->produto->nome} - {sitename}";
	
	}	
?>