<?
$menu_principal->show();

jimport('edesktop.programas.produtos.categorias');
$c = new edesktop_produtos_categorias();

$id = JRequest::getvar('id', 0);
$t = $c->busca_por_id($id);


// dados dafault 
if(!$id)
{
	$t->id = 0;
	$t->idpai = 0;
	$t->nome = '';
	$t->alias = '';
	$t->status = 1;
}

$this->smarty->assign('categoria', $t);


// select
$s = $c->cria_select_simples(0, 'class="w100" name="categoria[idpai]"', '--', $t->idpai, 0);
$this->smarty->assign('select', $s);


?>