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

// PATH'S
$ECOMP_VARS['ECOMP_PATH_TEMPLATE']      = JPATH_ROOT.DS.'templates'.DS.$defaultemplate;
$ECOMP_VARS['ECOMP_PATH_CACHE']         = JPATH_ROOT.DS.'cache'.DS.'ecomp';
$ECOMP_VARS['ECOMP_PATH_CACHE_ELOAD']   = JPATH_ROOT.DS.'cache'.DS.'eload';
$ECOMP_VARS['ECOMP_PATH_ADMIN']         = JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_ecomp';
$ECOMP_VARS['ECOMP_PATH_MEDIA']         = JPATH_ROOT.DS.'media'.DS.'com_ecomp';
$ECOMP_VARS['ECOMP_PATH_CLASS']         = $ECOMP_VARS['ECOMP_PATH_MEDIA'].DS.'class';
$ECOMP_VARS['ECOMP_PATH']               = $ECOMP_VARS['ECOMP_PATH_TEMPLATE'].DS.'html'.DS.'ecomp';
$ECOMP_VARS['ECOMP_PATH_IMAGENS']       = $ECOMP_VARS['ECOMP_PATH'].DS.'_imagens';
$ECOMP_VARS['ECOMP_PATH_UPLOADS']       = $ECOMP_VARS['ECOMP_PATH'].DS.'_uploads';
$ECOMP_VARS['ECOMP_PATH_TEMPLATES']     = $ECOMP_VARS['ECOMP_PATH'].DS.'_templates';
$ECOMP_VARS['ECOMP_PATH_TEMPLATES_MOD'] = $ECOMP_VARS['ECOMP_PATH'].DS.'_modulos';


//SMARTY
$ECOMP_VARS['ECOMP_PATH_SMARTY_CACHE']    = JPATH_ROOT.DS.'cache'.DS.'ecomp'.DS.'_cache';
$ECOMP_VARS['ECOMP_PATH_SMARTY_COPILE']   = JPATH_ROOT.DS.'cache'.DS.'ecomp'.DS.'_copile';
$ECOMP_VARS['ECOMP_PATH_SMARTY_TEMPLATE'] = $ECOMP_VARS['ECOMP_PATH_TEMPLATES'];


// URLS
$ECOMP_VARS['ECOMP_URL_TEMPLATE'] = 'templates/'.$defaultemplate;
$ECOMP_VARS['ECOMP_URL_UPLOADS']  = $ECOMP_VARS['ECOMP_URL_TEMPLATE'].'/html/ecomp/_uploads';
$ECOMP_VARS['ECOMP_URL_IMAGENS']  = $ECOMP_VARS['ECOMP_URL_TEMPLATE'].'/html/ecomp/_imagens';
$ECOMP_VARS['ECOMP_URL_MEDIA']    = JURI::root(1).'/media/com_ecomp/';


// TABELAS
$ECOMP_VARS['ECOMP_TABLE_JCOMPONENTS']          = '#__components';
$ECOMP_VARS['ECOMP_TABLE_COMPONENTES']          = '#__ecomp_componentes';
$ECOMP_VARS['ECOMP_TABLE_CAMPOS']               = '#__ecomp_campos';
$ECOMP_VARS['ECOMP_TABLE_TIPOS']                = '#__ecomp_campos_tipos';
$ECOMP_VARS['ECOMP_TABLE_CATEGORIAS']           = '#__ecomp_categorias';
$ECOMP_VARS['ECOMP_TABLE_TAGS']                 = '#__ecomp_tags';
$ECOMP_VARS['ECOMP_TABLE_CADASTROS_CATEGORIAS'] = '#__ecomp_cadastros_categorias';
$ECOMP_VARS['ECOMP_TABLE_CADASTROS_TAGS']       = '#__ecomp_cadastros_tags';
$ECOMP_VARS['ECOMP_TABLE_CADASTROS_IMAGENS']    = '#__ecomp_cadastros_imagens';
$ECOMP_VARS['ECOMP_TABLE_ROUTERS_RULES']        = '#__ecomp_routers_rules';
$ECOMP_VARS['ECOMP_TABLE_ROUTERS_CACHE']        = '#__ecomp_routers_cache';


// DEIXA A VAR ECOMP_VARS NA SESSÂO
$_SESSION['ECOMP_VARS'] = $ECOMP_VARS; 


// CRIA UMA CONSTANTE PARA CADA ITEM DENTRO DE $ECOMP_VARS 
foreach($ECOMP_VARS as $k => $v) define($k, $v);


// CRIAS ESTRUTURA DE PASTAS IMPORTANTES
if(!is_dir(ECOMP_PATH_CACHE)) @mkdir(ECOMP_PATH_CACHE);
if(!is_dir(ECOMP_PATH_SMARTY_CACHE)) @mkdir(ECOMP_PATH_SMARTY_CACHE);
if(!is_dir(ECOMP_PATH_SMARTY_COPILE)) @mkdir(ECOMP_PATH_SMARTY_COPILE);
if(!is_dir(ECOMP_PATH_SMARTY_TEMPLATE)) @mkdir(ECOMP_PATH_SMARTY_TEMPLATE);

?>
