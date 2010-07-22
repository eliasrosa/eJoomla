<?
$menu_textos->show();

jimport('edesktop.programas.produtos.textos');
jimport('edesktop.programas.produtos.produtos');
$t = new edesktop_produtos_textos();
$p = new edesktop_produtos_produtos();

$id = JRequest::getvar('id', 0);
$t = $t->busca_por_id($id);

$idproduto = JRequest::getvar('idproduto', 0);
$p = $p->busca_por_id($idproduto);

// dados dafault 
if(!$id)
{
	$t->id = 0;
	$t->idproduto = $p->id;
	$t->titulo = '';
	$t->html = '';
	$t->ordem = 1;
	$t->status = 1;
}

// adiciona os \n
$t->html = str_replace('<br>', "\n", $t->html);


$this->smarty->assign('texto', $t);
$this->smarty->assign('produto', $p);

?>