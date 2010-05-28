<?
$menu_principal->show();
$id = JRequest::getvar('id', 0);

jimport('edesktop.programas.produtos.produtos');
$p = new edesktop_produtos_produtos();
$p = $p->busca_por_id($id, true);

// dados dafault 
if(!$id)
{
	$p->produto->id = 0;
	$p->produto->idfabricante = 0;
	$p->produto->valor = 0;
	$p->produto->frete = 0;
	$p->produto->peso = 0;
	$p->produto->quantidade = 0;
	$p->produto->destaque = 0;
	$p->produto->status = 1;
}

$this->smarty->assign('produto', $p->produto);
$this->smarty->assign('imagem', $p->imagem);
$this->smarty->assign('imagens', $p->imagens);
$this->smarty->assign('fabricante', $p->fabricante);
$this->smarty->assign('textos', $p->textos);


// fabricantes
jimport('edesktop.programas.produtos.fabricantes');
$f = new edesktop_produtos_fabricantes();
$fabricantes = $f->busca_todos();
$this->smarty->assign('fabricantes', $fabricantes);


?>