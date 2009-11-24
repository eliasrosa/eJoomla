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


// PATHS
define('ECOMP_PATH_TEMPLATE',       JPATH_ROOT.DS.'templates'.DS.$defaultemplate);
define('ECOMP_PATH_CACHE',          JPATH_ROOT.DS.'cache'.DS.'ecomp');
define('ECOMP_PATH_CACHE_ELOAD',    JPATH_ROOT.DS.'cache'.DS.'eload');
define('ECOMP_PATH_ADMIN',          JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_ecomp');
define('ECOMP_PATH_MEDIA',          JPATH_ROOT.DS.'media'.DS.'com_ecomp');
define('ECOMP_PATH_CLASS',          ECOMP_PATH_MEDIA.DS.'class');

define('ECOMP_PATH',                ECOMP_PATH_TEMPLATE.DS.'html'.DS.'ecomp');
define('ECOMP_PATH_IMAGENS',        ECOMP_PATH.DS.'_imagens');
define('ECOMP_PATH_UPLOADS',        ECOMP_PATH.DS.'_uploads');
define('ECOMP_PATH_TEMPLATES',      ECOMP_PATH.DS.'_templates');
define('ECOMP_PATH_TEMPLATES_MOD',  ECOMP_PATH.DS.'_modulos');


//SMARTY
define('ECOMP_PATH_SMARTY_CACHE',    JPATH_ROOT.DS.'cache'.DS.'ecomp'.DS.'_cache');
define('ECOMP_PATH_SMARTY_COPILE',   JPATH_ROOT.DS.'cache'.DS.'ecomp'.DS.'_copile');
define('ECOMP_PATH_SMARTY_TEMPLATE', ECOMP_PATH_TEMPLATES);


// URLS
define('ECOMP_URL_TEMPLATE',  'templates/'.$defaultemplate);
define('ECOMP_URL_UPLOADS',   ECOMP_URL_TEMPLATE.'/html/ecomp/_uploads');
define('ECOMP_URL_IMAGENS',   ECOMP_URL_TEMPLATE.'/html/ecomp/_imagens');
define('ECOMP_URL_MEDIA',     JURI::root(1).'/media/com_ecomp/');


// TABELAS
define('ECOMP_TABLE_JCOMPONENTS',          '#__components');
define('ECOMP_TABLE_COMPONENTES',          '#__ecomp_componentes');
define('ECOMP_TABLE_CAMPOS',               '#__ecomp_campos');
define('ECOMP_TABLE_TIPOS',                '#__ecomp_campos_tipos');
define('ECOMP_TABLE_CATEGORIAS',           '#__ecomp_categorias');
define('ECOMP_TABLE_TAGS',                 '#__ecomp_tags');
define('ECOMP_TABLE_CADASTROS_CATEGORIAS', '#__ecomp_cadastros_categorias');
define('ECOMP_TABLE_CADASTROS_TAGS',       '#__ecomp_cadastros_tags');
define('ECOMP_TABLE_CADASTROS_IMAGENS',    '#__ecomp_cadastros_imagens');


// CRIAS ESTRUTURA DE PASTAS IMPORTANTES
if(!is_dir(ECOMP_PATH_CACHE)) @mkdir(ECOMP_PATH_CACHE);
if(!is_dir(ECOMP_PATH_SMARTY_CACHE)) @mkdir(ECOMP_PATH_SMARTY_CACHE);
if(!is_dir(ECOMP_PATH_SMARTY_COPILE)) @mkdir(ECOMP_PATH_SMARTY_COPILE);
if(!is_dir(ECOMP_PATH_SMARTY_TEMPLATE)) @mkdir(ECOMP_PATH_SMARTY_TEMPLATE);

?>
