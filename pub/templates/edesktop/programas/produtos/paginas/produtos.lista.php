<?
$menu_principal->show();

jimport('edesktop.programas.produtos.produtos');

$p = new edesktop_produtos_produtos();
$p = $p->busca_todos();

$this->smarty->assign('produtos', $p);
?>
