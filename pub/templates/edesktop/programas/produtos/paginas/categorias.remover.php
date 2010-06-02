<?
$ids = JRequest::getvar('ids');

if(count($ids) == 0)
	jexit(json_encode(array('tipo' => 'error', 'msg' => 'Nenhuma categoria foi selecionado!', 'retorno' => false)));	


foreach($ids as $id)
{
	jimport('edesktop.programas.produtos.categorias');

	$p = new edesktop_produtos_categorias();
	$c = $p->busca_por_id($id);
	
	
	$filhos = $p->busca_por_idpai($id);
	
	foreach($filhos as $f)
	{
		$f->status = 0;
		$f->idpai = $c->idpai;
			
		$f->update();
	}
	
	$p = $p->delete($id);
}

if(count($ids) == 1)
	$r = array('msg' => 'Categoria removida com sucesso!', 'retorno' => true);
else
	$r = array('msg' => 'Categorias removidas com sucesso!', 'retorno' => true);
	
jexit(json_encode($r));
?>