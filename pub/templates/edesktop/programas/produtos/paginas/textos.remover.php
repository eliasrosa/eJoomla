<?
$ids = JRequest::getvar('ids');

if(count($ids) == 0)
	jexit(json_encode(array('tipo' => 'error', 'msg' => 'Nenhum texto foi selecionado!', 'retorno' => false)));	


foreach($ids as $id)
{
	jimport('edesktop.programas.produtos.textos');

	$p = new edesktop_produtos_textos();
	$p = $p->delete($id);
}

if(count($ids) == 1)
	$r = array('msg' => 'Texto removido com sucesso!', 'retorno' => true);
else
	$r = array('msg' => 'Textos removidos com sucesso!', 'retorno' => true);
	
jexit(json_encode($r));
?>