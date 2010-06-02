<?
$menu_principal->show();

jimport('edesktop.programas.produtos.categorias');
$t = new edesktop_produtos_categorias();

$lista = $t->cria_lista_simples();
$this->smarty->assign('lista', $lista);
?>