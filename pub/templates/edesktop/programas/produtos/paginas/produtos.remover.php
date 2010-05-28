<?
$ids = JRequest::getvar('ids');

if(count($ids) == 0)
	jexit(json_encode(array('tipo' => 'error', 'msg' => 'Nenhum produto foi selecionado!', 'retorno' => false)));	


jimport('edesktop.programas.produtos.produtos');
	
foreach($ids as $id)
{
	$p = new edesktop_produtos_produtos();
	$p = $p->delete($id);
}

if(count($ids) == 1)
	$r = array('msg' => 'Produto removido com sucesso!', 'retorno' => true);
else
	$r = array('msg' => 'Produtos removidos com sucesso!', 'retorno' => true);
	
jexit(json_encode($r));
?>