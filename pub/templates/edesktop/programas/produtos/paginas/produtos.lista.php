<?
$menu_principal->show();

jimport('edesktop.programas.produtos');
$edProdutos = new edProdutos();

$produtos = $edProdutos->busca_todos_produtos("WHERE status >= 0 ORDER BY nome ASC", array('imagem'));

$this->smarty->assign('produtos', $produtos);
$this->smarty->assign('paginacao', $edProdutos->paginacao);
?>
