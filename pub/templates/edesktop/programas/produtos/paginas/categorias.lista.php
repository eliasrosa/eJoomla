<?
$menu_principal->show();

jimport('edesktop.programas.produtos.categorias');
$t = new edesktop_produtos_categorias();

$categorias = $t->busca_todas();
$this->smarty->assign('categorias', $categorias);
?>