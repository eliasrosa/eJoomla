<?php
	// adiciona o plugin de mascaras
	JHTML::script('jquery.meio.mask.min.js', 'media/com_edesktop/loja/js/');

	// adiciona o plugin de validaForm
	JHTML::script('jquery.validaform-1.0.13.js', 'media/com_edesktop/loja/js/');

	// adiciona o javascript do produto
	JHTML::script('produto.js', 'media/com_edesktop/loja/js/');

	// carrega o id do produto
	$id = JRequest::getInt('id', 0);

	// importa a class produtos
	jimport('edesktop.programas.loja');

	// busca dados
	$dados = edProdutos::getInstance()
				->busca_produto_ativo_por_id($id)
				->fetchOne();

	// remove imagem duplicada caso esteja em  destaque
	if($dados)
		foreach($dados->Imagens as $k=>$i)
			if($dados->imagem->id == $i->id)
				unset($dados->Imagens[$k]);

	// envia para o layout
	$this->assignRef('dados', $dados);

	if(0)
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