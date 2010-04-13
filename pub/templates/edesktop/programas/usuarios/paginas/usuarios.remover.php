<?
$ids = JRequest::getvar('ids');

if(count($ids) == 0)
	jexit(json_encode(array('tipo' => 'error', 'msg' => 'Nenhum usuário foi selecionado!', 'retorno' => false)));	

foreach($ids as $id)
{
	$u = new JCRUD('jos_users');
	$u = $u->busca_por_id($id);
	$u->delete();
	
	$aro = new JCRUD("jos_core_acl_aro");
	$aro = $aro->busca_por_id($u->id, 'value');
	$aro->delete();
	
	$groups_aro_map = new JCRUD("jos_core_acl_groups_aro_map");
	$groups_aro_map = $groups_aro_map->busca_por_id($aro->id, 'aro_id');
	$groups_aro_map->delete($aro->id, 'aro_id');
}

if(count($ids) == 1)
	$r = array('msg' => 'Usuário removido com sucesso!', 'retorno' => true);
else
	$r = array('msg' => 'Usuários removidos com sucesso!', 'retorno' => true);
	
jexit(json_encode($r));
?>