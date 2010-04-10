<?
$ids = JRequest::getvar('ids');


foreach($ids as $id)
{
	$u = new JCRUD("jos_users");
	$u = $u->busca_por_id($id);
	$u->delete();
}

if(count($ids) == 1)
	echo "{'msg' : 'Usuário removido com sucesso!' }";
else
	echo "{'msg' : 'Usuários removidos com sucesso!' }";
?>
