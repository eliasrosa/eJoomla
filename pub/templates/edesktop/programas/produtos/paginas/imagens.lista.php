<?
$idproduto = JRequest::getvar('idproduto', 0);
$menu_imagens->show();

jimport('edesktop.programas.produtos.imagens');
$imagens = new edesktop_produtos_imagens();
$imagens = $imagens->busca_por_produto($idproduto, true);
$this->smarty->assign('imagens', $imagens);

jimport('edesktop.programas.produtos.produtos');
$produto = new edesktop_produtos_produtos();
$produto = $produto->busca_por_id($idproduto);
$this->smarty->assign('produto', $produto);


?>