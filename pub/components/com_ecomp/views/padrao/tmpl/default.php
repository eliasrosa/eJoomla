<?php
// no direct access
defined('_JEXEC') or die('Restricted access');


// inicio o smarty
$smarty = new Smarty();
$smarty->template_dir = ECOMP_PATH_SMARTY_TEMPLATE;
$smarty->compile_dir  = ECOMP_PATH_SMARTY_COPILE;
$smarty->cache_dir    = ECOMP_PATH_SMARTY_CACHE;

// envia todas as constantes para o smarty
foreach($_SESSION['ECOMP_VARS'] as $k => $v)
{
	$smarty->assign($k, $v);
}


// carrega as variaveis padrao
$idcadastro   = $this->params->get('idcadastro');
$id           = JRequest::getInt('id', $idcadastro);
$idcategoria  = JRequest::getInt('idcategoria', 0);
$idcomponente = $this->params->get('idcomponente');
$titulo       = $this->params->get('titulo');
$pasta        = $this->params->get('pasta');
$arquivo      = $this->params->get('arquivo');
$tipo         = $this->params->get('tipo');
$template     = $this->params->get('template');
$doc          =& JFactory::getDocument();
$html         = '';
$cadastro     = '';
$cadastros    = array();


// arquivos
$file_js_path  = ECOMP_PATH.DS.$pasta.DS.$arquivo.'.js';
$file_js_url   = ECOMP_URL_TEMPLATE."/html/ecomp/$pasta/$arquivo.js";
$file_css_path = ECOMP_PATH.DS.$pasta.DS.$arquivo.'.css';
$file_css_url  = ECOMP_URL_TEMPLATE."/html/ecomp/$pasta/$arquivo.css";
$file_php      = ECOMP_PATH.DS.$pasta.DS.$arquivo.'.php';
$file_html     = ECOMP_PATH.DS.$pasta.DS.$arquivo.'.html';
$file_tipo     = ECOMP_PATH_MEDIA.DS.'views'.DS.'padrao'.DS.$tipo.'.php';


// paths
$path_templates = ECOMP_PATH_MEDIA.DS.'views'.DS.'padrao'.DS.'templates';


// nome da tebela do componente
$tabela = eHelper::componente_tabela_nome($idcomponente);

// envia vars para o template
$smarty->assign('id', $id);
$smarty->assign('idcategoria', $idcategoria);
$smarty->assign('idcomponente', $idcomponente);


// executa a funçao de acordo com o tipo selecionado
if($tipo != -1) 
	require_once($file_tipo);


// tenta abrir o js, css e php
if(file_exists($file_js_path))  $doc->addScript($file_js_url);
if(file_exists($file_css_path)) $doc->addStyleSheet($file_css_url);
if(file_exists($file_php)) require($file_php); 


// envia vars para o template
$smarty->assign('cadastro',           $cadastro);
$smarty->assign('cadastros',          $cadastros);
$smarty->assign('titulo',             $titulo);
$smarty->assign('classes',            $pasta);


// tenta abrir o arquivo html
if(file_exists($file_html)) $html = $smarty->fetch($file_html);
else $html = "Arquivo {$file_html} não foi encontrado!";


// carrega o html para o template
$smarty->assign('html', $html);


// tenta abrir o arquivo template
$file_template = $path_templates.DS.$template.'.html';
if(file_exists($file_template))
{
	echo $smarty->fetch($file_template);
}
else
{
	$file_template = ECOMP_PATH_TEMPLATES.DS.$template.'.html';
	if(file_exists($file_template))
		echo $smarty->fetch($file_template);
	else
		echo "Arquivo {$file_template} não foi encontrado!";
}

?>
