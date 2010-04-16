<?

// recebe todo os dados
$dados = $_POST;
$msg = '';

if(isset($dados['id']) && $dados['id'] == 1)
	$msg .= '- Este grupo de usuário está protegido pelo sistema, não pode ser alterado!<br>';

if(empty($dados['nome']))
	$msg .= '- O campo \'Nome\' é obrigatório!<br>';
else
{
	// Nomes duplicados
	$edit = isset($dados['id']) ? "AND id != '{$dados['id']}'" : '';
	$tabela = new JCRUD('jos_edesktop_usuarios_grupos');
	$nome = $tabela->busca("WHERE nome = '{$dados['nome']}' {$edit} Limit 0,1");
	if(count($nome))
		$msg .= '- O nome do grupo já está registrado.<br>';
}

if(!empty($msg))
	jexit(json_encode(array('tipo' => 'error', 'msg' => 'Preencha corretamente o(s) seguinte(s) campo(s):<br><br>'.$msg)));


// remove a var limit
unset($dados['limit']);


// permissoes
$permissoes = '';
$permissoes_novas = JRequest::getvar('permissoes', array());
$permissoes_total = count($permissoes_novas);
$permissoes_count = 0;
foreach($permissoes_novas as $permissao)
{
	$permissoes_count++;
	$permissoes .= ($permissoes_count != $permissoes_total) ? "{$permissao}\n" : $permissao;
}
$dados['permissoes'] = $permissoes;


// abre a tabela com os novo dados
$grupo = new JCRUD('jos_edesktop_usuarios_grupos', $dados);


// verifica se o registro já existe
if($grupo->id)
{
	// atualiza os dados do registro
	$grupo->update();
	
	// carrega as vars de retorno
	$retorno = 'updateOk';
	$msg = 'Dados do grupo de usuário foram atualizados com sucesso!';
}
else
{
	// cadastra o novo registro
	$grupo->insert();
	
	// carrega as vars de retorno
	$retorno = 'insertOk';
	$msg = 'Grupo de usuário cadastrado com sucesso!';
		
}
	
jexit(json_encode(array('msg' => $msg, 'retorno' => $retorno, 'id' => $grupo->id )));
?>