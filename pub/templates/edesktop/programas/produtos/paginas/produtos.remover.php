<?
$ids = JRequest::getvar('ids');

if(count($ids) == 0)
	jexit(json_encode(array('tipo' => 'error', 'msg' => 'Nenhum produto foi selecionado!', 'retorno' => false)));	


foreach($ids as $id)
{

}

if(count($ids) == 1)
	$r = array('msg' => 'Produto removido com sucesso!', 'retorno' => true);
else
	$r = array('msg' => 'Produtos removidos com sucesso!', 'retorno' => true);
	
jexit(json_encode($r));
?>