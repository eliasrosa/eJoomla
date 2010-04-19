<?
$id = JRequest::getvar('id', 0);

$menu_grupos->show();

$grupo = new JCRUD("jos_edesktop_usuarios_grupos");
$grupo = $grupo->busca_por_id($id);

if(!$id)
{
	$grupo->status = 1;
	$grupo->permissoes = '';
}

// permissoes
$grupo->permissoes = ($grupo->permissoes != '') ? explode("\n", $grupo->permissoes) : array();;


// grupo
$this->smarty->assign('grupo', $grupo);


/* permições
 *******************/
$programas = JFolder::folders(EDESKTOP_PATH_PROGRAMAS);
$permissoes = array();
foreach($programas as $programa)
{
	// pega as configuracoes
	$config = $this->get_config($programa, false, false);
	
	// inicia a var dados
	$dados = array();

	// carrega o nome do programa
	$dados['programa'] = $programa;
	
	// carrega o titulo
	$dados['titulo'] = $config['titulo'];
	
	// carrega as permicoes
	$dados['permissoes'] = array();
	foreach($config['permissoes'] as $permissao => $descricao)
		$dados['permissoes']["{$programa}.{$permissao}"] = $descricao;
	
	// carrega o finder
	if($config['finder'])
		$dados['permissoes'] = array_merge(array($programa.'.finder' => 'Fazer pesquisas usando a "Busca rápida"'), $dados['permissoes']);
		
	// adiciona na array principal
	$permissoes[] = $dados;
}

// permições dos programas
$this->smarty->assign('programas', $permissoes);

$this->smarty->register_function("ckp", "check_permisao");

function check_permisao ($params) {
    extract($params);
			
	if(array_search($k, $array) !== false)
		return 'checked="checked"';
	
}




?>