<?
$menu_principal->show();
$id = JRequest::getvar('id', 0);

jimport('edesktop.programas.produtos.produtos');
$pd = new edesktop_produtos_produtos();
$p = $pd->busca_por_id($id, true);

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


jimport('edesktop.programas.produtos.categorias');
$p = new edesktop_produtos_categorias();
$categorias = $p->cria_lista_simples(0);
$js = $pd->busca_categorias($id);
$js = 'var categorias = {ids: [' .$js. ']}; $.each(categorias.ids, function(i, v){ var $c = $(\'ul.lista li input[value="\' +v+ \'"]\', $("#d'.$this->processID.'")); $c.attr("checked", "checked");  });';
$js = '<script type="text/javascript">'.$js.'</script>';
$this->smarty->assign('categorias', $categorias.$js);


?>