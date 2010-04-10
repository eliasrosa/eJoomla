<?
$ids = JRequest::getvar('ids');


foreach($ids as $id)
{
	$u = new JCRUD("jos_users");
	$u = $u->busca_por_id($id);
	$u->delete();
}

?>
{'msg' : 'Usuário(s) removido(s) com sucesso!' }
