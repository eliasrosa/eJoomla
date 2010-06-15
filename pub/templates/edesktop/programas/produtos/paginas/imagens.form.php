<?
$menu_imagens->show();

jimport('edesktop.programas.produtos.imagens');
jimport('edesktop.programas.produtos.produtos');
$imagem = new edesktop_produtos_imagens();
$produto = new edesktop_produtos_produtos();

$id = JRequest::getvar('id', 0);
$imagem = $imagem->busca_por_id($id);

$idproduto = JRequest::getvar('idproduto', 0);
$produto = $produto->busca_por_id($idproduto);

// dados dafault 
if(!$id)
{
	$imagem->id = 0;
	$imagem->idproduto = $produto->id;
	$imagem->nome = '';
	$imagem->destaque = 0;
	$imagem->status = 1;
}


$this->smarty->assign('imagem', $imagem);
$this->smarty->assign('produto', $produto);

//print_r($imagem);

?>