<?php
defined('_JEXEC') or die( "Acesso Restrito" );

// carrega o raquivo comum
require_once(JPATH_ROOT.DS.'media'.DS.'com_ecomp'.DS.'comum.php');

// carrega o jcrud
require_once(ECOMP_PATH_CLASS.DS.'ebasic.jcrud.php');

// carrega o jcrud
require_once(ECOMP_PATH_CLASS.DS.'smarty'.DS.'Smarty.class.php');

// carrega o jcrud
require_once(ECOMP_PATH_CLASS.DS.'ebasic.util.php');

// carrega o helper
require_once(ECOMP_PATH_CLASS.DS.'ebasic.helper.php');

// inicia o smarty
$smarty = new Smarty();
$smarty->template_dir = ECOMP_PATH_SMARTY_TEMPLATE;
$smarty->compile_dir  = ECOMP_PATH_SMARTY_COPILE;
$smarty->cache_dir    = ECOMP_PATH_SMARTY_CACHE;

// id do componente
$idcomponente = $params->getValue('idcomponente');

// inicio do nome do arquivo
$file = eUtil::texto_limpo($module->title, true);

// pasta do arquivo
$path = eUtil::texto_limpo($module->position);

// file php
$file_php = ECOMP_PATH_TEMPLATE_MOD.DS.$path.DS.$file.'.php';

// file smarty
$file_smarty = ECOMP_PATH_TEMPLATE_MOD.DS.$path.DS.$file.'.html';

// abre o componente
$componente = new JCRUD(ECOMP_TABLE_COMPONENTES, array('id' => $idcomponente));

// tabela do componente
$tabela = ECOMP_TABLE_COMPONENTES.'_'.$componente->alias;

// pastas
$smarty->assign('url_imagens', ECOMP_URL_IMAGES);
$smarty->assign('url_uploads', ECOMP_URL_UPLOADS);

// id componente
$smarty->assign('idcomponente', $idcomponente);


// abre o arquivo
if (file_exists($file_php))
	require_once($file_php);

// exibe o template do modulo
if(file_exists($file_smarty))
	$smarty->display($file_smarty);

?>

