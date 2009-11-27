<?php
// TEMPLATE
global $mainframe;
if ($mainframe->isAdmin())
{
	$db =& JFactory::getDBO();
	$query = "SELECT template FROM #__templates_menu WHERE client_id = 0 AND menuid = 0";
	$db->setQuery($query);
	$defaultemplate = $db->loadResult();
}
else
{
	$defaultemplate = JFactory::getApplication()->getTemplate();
}


$_var['ECOMP_PATH_TEMPLATE']    = JPATH_ROOT.DS.'templates'.DS.$defaultemplate;
$_var['ECOMP_PATH_CACHE']       = JPATH_ROOT.DS.'cache'.DS.'ecomp';
$_var['ECOMP_PATH_CACHE_ELOAD'] = JPATH_ROOT.DS.'cache'.DS.'eload';
$_var['ECOMP_PATH_ADMIN']       = JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_ecomp';
$_var['ECOMP_PATH_MEDIA']       = JPATH_ROOT.DS.'media'.DS.'com_ecomp';
$_var['ECOMP_PATH_CLASS']       = $_var['ECOMP_PATH_MEDIA'].DS.'class';


$_var['ECOMP_PATH']               = $_var['ECOMP_PATH_TEMPLATE'].DS.'html'.DS.'ecomp';
$_var['ECOMP_PATH_IMAGENS']       = $_var['ECOMP_PATH'].DS.'_imagens';
$_var['ECOMP_PATH_UPLOADS']       = $_var['ECOMP_PATH'].DS.'_uploads';
$_var['ECOMP_PATH_TEMPLATES']     = $_var['ECOMP_PATH'].DS.'_templates';
$_var['ECOMP_PATH_TEMPLATES_MOD'] = $_var['ECOMP_PATH'].DS.'_modulos';


//SMARTY
$_var['ECOMP_PATH_SMARTY_CACHE']    = JPATH_ROOT.DS.'cache'.DS.'ecomp'.DS.'_cache';
$_var['ECOMP_PATH_SMARTY_COPILE']   = JPATH_ROOT.DS.'cache'.DS.'ecomp'.DS.'_copile';
$_var['ECOMP_PATH_SMARTY_TEMPLATE'] = $_var['ECOMP_PATH_TEMPLATES'];


// URLS
$_var['ECOMP_URL_TEMPLATE'] = 'templates/'.$defaultemplate;
$_var['ECOMP_URL_UPLOADS']  = $_var['ECOMP_URL_TEMPLATE'].'/html/ecomp/_uploads';
$_var['ECOMP_URL_IMAGENS']  = $_var['ECOMP_URL_TEMPLATE'].'/html/ecomp/_imagens';
$_var['ECOMP_URL_MEDIA']    = JURI::root(1).'/media/com_ecomp/';


// TABELAS
$_var['ECOMP_TABLE_JCOMPONENTS']          = '#__components';
$_var['ECOMP_TABLE_COMPONENTES']          = '#__ecomp_componentes';
$_var['ECOMP_TABLE_CAMPOS']               = '#__ecomp_campos';
$_var['ECOMP_TABLE_TIPOS']                = '#__ecomp_campos_tipos';
$_var['ECOMP_TABLE_CATEGORIAS']           = '#__ecomp_categorias';
$_var['ECOMP_TABLE_TAGS']                 = '#__ecomp_tags';
$_var['ECOMP_TABLE_CADASTROS_CATEGORIAS'] = '#__ecomp_cadastros_categorias';
$_var['ECOMP_TABLE_CADASTROS_TAGS']       = '#__ecomp_cadastros_tags';
$_var['ECOMP_TABLE_CADASTROS_IMAGENS']    = '#__ecomp_cadastros_imagens';


// Todas as contantes reunidas em uma
define('ECOMP_VARS', $_var);


// CRIA UMA CONSTANTE PARA CADA ITEM DENTRO DE $_VAR 
foreach(ECOMP_VARS as $k => $v) define($k, $v);


// CRIAS ESTRUTURA DE PASTAS IMPORTANTES
if(!is_dir(ECOMP_PATH_CACHE)) @mkdir(ECOMP_PATH_CACHE);
if(!is_dir(ECOMP_PATH_SMARTY_CACHE)) @mkdir(ECOMP_PATH_SMARTY_CACHE);
if(!is_dir(ECOMP_PATH_SMARTY_COPILE)) @mkdir(ECOMP_PATH_SMARTY_COPILE);
if(!is_dir(ECOMP_PATH_SMARTY_TEMPLATE)) @mkdir(ECOMP_PATH_SMARTY_TEMPLATE);

?>
