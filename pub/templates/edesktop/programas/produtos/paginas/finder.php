<?
jimport('edesktop.programas.produtos');

$finder = JRequest::getvar('finder');
$this->smarty->assign('finder', $finder);

// produtos
$produtos = new edProdutos();
$produtos_dados = $produtos->busca_produtos_por_texto($finder, "AND status >= 0 ORDER BY nome ASC", array('imagem'));
$this->smarty->assign('produtos', $produtos_dados);
$this->smarty->assign('paginacao', $produtos->paginacao);
?>
