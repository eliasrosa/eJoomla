<?php
function jAccess($var, $params = array())
{
    // Carrega as sessoes
    $usuario = $_SESSION['eDesktop.usuario'];
    $grupo = $_SESSION['eDesktop.usuario.grupo'];
    $permissoes = $_SESSION['eDesktop.usuario.grupo.permissoes'];

    // Se o usuário for Administrador, tem acesso liberado (FULL)
    if($grupo['id'] != 1)
    {
	// Mescla os parametros
	$params = array_merge(array(
		'retorno' => 'txt',
		'programa' => false
		), $params);

	// Verifica o parametro programa
	if(!$params['programa'])
	    $params['programa'] = JRequest::getvar('programa');

	// Carrega a var programa
	$permissao = "{$params['programa']}.{$var}";
	$permissoes = array_flip($permissoes);
	$result = isset($permissoes[$permissao]);

	// Verifica se o usuário tem permissão
	if(!$result)
	{
	    jimport('edesktop.programa');

	    $config = new programa();

	    // Carrega as configurações do programa
	    $config = $config->get_config($params['programa'], false, false);

	    // Carrega a var
	    $liberadas = array_flip($config['permissoes.liberadas']);

	    // verifica se o pagina está liberada para todos
	    if(!isset($liberadas[$var]))
	    {
		// Se o tipo de retorno for boolean
		if($params['retorno'] == 'bool')
		    return false;
		else
		    return true;

		// Se o tipo de retorno for texto
		if($params['retorno'] == 'txt')
		{
		    $funcao = JRequest::getvar('funcao');
		    $msg = "Acesso negado! Você não tem permissão para acessar essa página ($permissao)!";
		    if($funcao)
			jexit("{ 'msg' : '{$msg}', 'tipo' : 'error' }");
		    else
			jexit("eDesktop: {$msg}");
		}
	    }
	}
    }

    return true;
}
?>
