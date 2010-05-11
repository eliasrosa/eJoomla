<?php
	// carrega o id do produto
	$id = JRequest::getvar('id', 0);

	// busca dados
	$dados = $produtos->busca_por_id($id, true);

	// envia para o layout
	$this->assignRef('dados', $dados);

	// Description e keywords
	$doc =& JFactory::getDocument();
	$description = $dados->produto->metatagdescription ? $dados->produto->metatagdescription : $dados->produto->descricao;
	$description = substr(strip_tags($description), 0, 160);
	$doc->setMetaData('description', $description );
	$doc->setMetaData('keywords', $dados->produto->metatagkey);


	// Altera o titulo
	$_SESSION['eload']['title'] = "{$dados->produto->nome} - {$dados->fabricante->nome} - {sitename}";
?>