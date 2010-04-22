<?
$ids = JRequest::getvar('ids');

if(count($ids) == 0)
	jexit(json_encode(array('tipo' => 'error', 'msg' => 'Nenhum grupo de usuários foi selecionado!', 'retorno' => false)));	

foreach($ids as $id)
{
	$g = new JCRUD('jos_edesktop_usuarios_grupos');
	$g = $g->busca_por_id($id);

	$u = new JCRUD('jos_users');
	$u = $u->busca("WHERE id_grupo = '$id'");

	if(count($u))
	    jexit(json_encode(array('tipo' => 'error', 'msg' => "Operação cancelada! Existe um ou mais usuários cadastrados no grupo {$g->nome}", 'retorno' => false)));
}

foreach($ids as $id)
{
	$u = new JCRUD('jos_edesktop_usuarios_grupos');
	$u = $u->busca_por_id($id);
	$u->delete();
}

if(count($ids) == 1)
	$r = array('msg' => 'Grupo de usuários removido com sucesso!', 'retorno' => true);
else
	$r = array('msg' => 'Grupos de usuários removidos com sucesso!', 'retorno' => true);
	
jexit(json_encode($r));
?>