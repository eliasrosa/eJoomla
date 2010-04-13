<?

// recebe todo os dados
$dados = $_POST;
$t = new JCRUD('jos_users');

$msg = '';


if(empty($dados['name']))
	$msg .= '- O campo \'Nome\' é obrigatório!<br>';


if(empty($dados['email']))
{
	$msg .= '- O campo \'E-mail\' é obrigatório!<br>';
}
else
{
	// busca por e-mail duplicado
	$edit = isset($dados['id']) ? "AND id != '{$dados['id']}'" : '';
	$email = $t->busca("WHERE email = '{$dados['email']}' {$edit} Limit 0,1");
	if(count($email))
		$msg .= '- O endereço de e-mail já está registrado.<br>';
}


// verifica se o é o user admin
if(@$dados['id'] != 62) //is admin
{
	if(empty($dados['id_grupo']))
		$msg .= '- O campo \'Grupo\' é obrigatório!<br>';


	if(empty($dados['gid']))
		$msg .= '- O campo \'Grupo Joomla!\' é obrigatório!<br>';
	
	
	if($dados['gid'] == 29 || $dados['gid'] == 30)
		$msg .= ' - Os grupos "Público do Site" e "Público da Administração" do Joomla! não estão disponíveis.<br>';
	

	// verifica usuarios
	if(isset($dados['username']))
	{
		if(empty($dados['username']))
		{
			$msg .= '- O campo \'Usuário\' é obrigatório.<br>';
		}
		else
		{
			// busca por usuário duplicado
			$edit = isset($dados['id']) ? "AND id != '{$dados['id']}'" : '';
			$email = $t->busca("WHERE username = '{$dados['username']}' {$edit} Limit 0,1");
			if(count($email))
				$msg .= '- Este nome de usuário já está em uso.<br>';
		}
	}

	// carrega o usertype
	$usertype = new JCRUD('jos_core_acl_aro_groups', array('id' => $dados['gid']));
	$dados['usertype'] = $usertype->value;

}

if(!isset($dados['block']))
	$dados['block'] = 0;


// verifica as senhas
if(empty($dados['password']))
{
	// remove as senha nulas
	unset($dados['password'], $dados['password2']);
}
else
{	
	if($dados['password'] == $dados['password2'])
	{
		jimport('joomla.user.helper');

		$salt = JUserHelper::genRandomPassword(32);
		$crypt = JUserHelper::getCryptedPassword($dados['password'], $salt);
		$dados['password'] = $crypt.':'.$salt;
		
		// remove as senha2
		unset($dados['password2']);
	}
	else
	{
		$msg .= '- As senhas não estão iguais.<br>';
		
	}	
}

if(!empty($msg))
	jexit(json_encode(array('tipo' => 'error', 'msg' => 'Preencha corretamente o(s) seguinte(s) campo(s):<br><br>'.$msg)));


// remove a var limit
unset($dados['limit']);

// abre a tabela com os novo dados
$usuario = new JCRUD('jos_users', $dados);

// verifica se o registro já existe
if($usuario->id)
{
	// atualiza os dados do usuario
	$usuario->update();

	// verifica se o user admin
	if($usuario->id != 62)
	{
		// adiciona valores na tabela jos_core_acl_aro
		$aro = new JCRUD("jos_core_acl_aro");
		$aro = $aro->busca_por_id($usuario->id, 'value');
		$aro->name = $usuario->name;
		$aro->update();


		// adiciona valores na tabela jos_core_acl_groups_aro_map
		$groups_aro_map = new JCRUD("jos_core_acl_groups_aro_map");
		$groups_aro_map = $groups_aro_map->busca_por_id($aro->id, 'aro_id');
		$groups_aro_map->group_id = $dados['gid'];
		$groups_aro_map->update('aro_id');	
	}
	
	// carrega as vars de retorno
	$retorno = 'updateOk';
	$msg = 'Dados do usuário foram atualizados com sucesso!';
}
else
{
	// adiciona a data de registro
	$usuario->registerDate = date("Y-m-d H:i:s");
	
	
	// cadastra o novo registro
	$usuario->insert();
	
	
	// adiciona valores na tabela jos_core_acl_aro
	$aro = new JCRUD("jos_core_acl_aro");
	$aro->section_value = 'users';
	$aro->value = $usuario->id;
	$aro->order_value = 0;
	$aro->name = $usuario->name;
	$aro->hidden = 0;
	$aro->insert();
	
	
	// adiciona valores na tabela jos_core_acl_groups_aro_map
	$groups_aro_map = new JCRUD("jos_core_acl_groups_aro_map");
	$groups_aro_map->group_id = $usuario->gid;
	$groups_aro_map->section_value = '';
	$groups_aro_map->aro_id = $aro->id;
	$groups_aro_map->insert();
	
	// carrega as vars de retorno
	$retorno = 'insertOk';
	$msg = 'Usuário cadastrado com sucesso!';
		
}
	
jexit(json_encode(array('msg' => $msg, 'retorno' => $retorno, 'id' => $usuario->id )));
?>