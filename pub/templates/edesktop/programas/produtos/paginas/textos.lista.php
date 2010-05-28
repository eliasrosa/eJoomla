<?
jimport('edesktop.programas.produtos.textos');
jimport('edesktop.programas.produtos.produtos');
$t = new edesktop_produtos_textos();
$p = new edesktop_produtos_produtos();

$idproduto = JRequest::getvar('idproduto', 0);

$t = $t->busca_por_produto($idproduto);
$p = $p->busca_por_id($idproduto);

$this->smarty->assign('textos', $t);
$this->smarty->assign('produto', $p);

?>