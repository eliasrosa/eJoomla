<?

jimport('edesktop.programas.produtos.textos');

$id = JRequest::getvar('idproduto', 0);

$p = new edesktop_produtos_textos();
$p = $p->busca_por_produto($id);

$this->smarty->assign('textos', $p);

?>
