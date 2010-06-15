<?
$ids = JRequest::getvar('ids');

if(count($ids) == 0)
	jexit(json_encode(array('tipo' => 'error', 'msg' => 'Nenhuma imagem foi selecionada!', 'retorno' => false)));	


foreach($ids as $id)
{
	jimport('edesktop.programas.produtos.imagens');

	$p = new edesktop_produtos_imagens();
	$p = $p->delete($id);
}

if(count($ids) == 1)
	$r = array('msg' => 'Imagem removida com sucesso!', 'retorno' => true);
else
	$r = array('msg' => 'Imagens removidas com sucesso!', 'retorno' => true);
	
jexit(json_encode($r));
?>