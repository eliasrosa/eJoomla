<?php
defined('_JEXEC') or die( "Acesso Restrito" );


// carrega o raquivo comum
require_once(JPATH_ROOT.DS.'media'.DS.'com_ecomp'.DS.'comum.php');


// carrega o jcrud
jimport('edesktop.jcrud');


// carrega o jcrud
jimport('edesktop.smarty.class');


// carrega o jcrud
require_once(ECOMP_PATH_CLASS.DS.'ebasic.util.php');


// carrega o helper
require_once(ECOMP_PATH_CLASS.DS.'ebasic.helper.php');


// inicia o smarty
$smarty = new Smarty();
$smarty->template_dir = ECOMP_PATH_SMARTY_TEMPLATE;
$smarty->compile_dir  = ECOMP_PATH_SMARTY_COPILE;
$smarty->cache_dir    = ECOMP_PATH_SMARTY_CACHE;

// envia todas as constantes para o smarty
foreach($_SESSION['ECOMP_VARS'] as $k => $v)
{
	$smarty->assign($k, $v);
}


// id do componente
$idcomponente = $params->getValue('idcomponente');


// inicio do nome do arquivo
$file = eUtil::texto_limpo($module->title, true);


// pasta do arquivo
$path = eUtil::texto_limpo($module->position);


// file php
$file_php = ECOMP_PATH_TEMPLATES_MOD.DS.$path.DS.$file.'.php';


// file smarty
$file_smarty = ECOMP_PATH_TEMPLATES_MOD.DS.$path.DS.$file.'.html';


// tabela do componente
$tabela = eHelper::componente_tabela_nome($idcomponente);


// id componente
$smarty->assign('idcomponente', $idcomponente);


// abre o arquivo
if (file_exists($file_php)) require_once($file_php);
else echo "Arquivo {$file_php} não foi encontrado!";


// exibe o template do modulo
if(file_exists($file_smarty)) $smarty->display($file_smarty);
else echo "Arquivo {$file_smarty} não foi encontrado!";

?>

