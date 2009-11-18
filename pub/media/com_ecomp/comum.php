<?php

// PATHS
define('ECOMP_PATH_CACHE',          JPATH_ROOT.DS.'cache'.DS.'com_ecomp');
define('ECOMP_PATH_CACHE_ELOAD',    JPATH_ROOT.DS.'cache'.DS.'eload');
define('ECOMP_PATH_ADMIN',          JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_ecomp');
define('ECOMP_PATH_MEDIA',          JPATH_ROOT.DS.'media'.DS.'com_ecomp');
define('ECOMP_PATH_CLASS',          ECOMP_PATH_MEDIA.DS.'class');
define('ECOMP_PATH_IMAGES',         JPATH_ROOT.DS.'images'.DS.'com_ecomp');
define('ECOMP_PATH_UPLOADS',        ECOMP_PATH_MEDIA.DS.'uploads');
define('ECOMP_PATH_TEMPLATE',       JPATH_THEMES.DS.JFactory::getApplication()->getTemplate());
define('ECOMP_PATH_TEMPLATE_MOD',   JPATH_THEMES.DS.JFactory::getApplication()->getTemplate().DS.'html'.DS.'mod_ecomp');
define('ECOMP_PATH_IMAGES_UPLOADS', ECOMP_PATH_IMAGES.DS.'uploads');

//SMARTY
define('ECOMP_PATH_SMARTY_CACHE',    JPATH_ROOT.DS.'cache'.DS.'com_ecomp'.DS.'cache');
define('ECOMP_PATH_SMARTY_COPILE',   JPATH_ROOT.DS.'cache'.DS.'com_ecomp'.DS.'copile');
define('ECOMP_PATH_SMARTY_TEMPLATE', ECOMP_PATH_TEMPLATE.DS.'html'.DS.'com_ecomp');

// URLS
define('ECOMP_URL_TEMPLATE', 'templates/'.JFactory::getApplication()->getTemplate());
define('ECOMP_URL_UPLOADS',  'media/com_ecomp/uploads');
define('ECOMP_URL_IMAGES',   'images/com_ecomp');

// URLS
define('ECOMP_URL_MEDIA', JURI::root(1).'/media/com_ecomp/');

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
if(!is_dir(ECOMP_PATH_CACHE)) mkdir(ECOMP_PATH_CACHE);
if(!is_dir(ECOMP_PATH_SMARTY_CACHE)) mkdir(ECOMP_PATH_SMARTY_CACHE);
if(!is_dir(ECOMP_PATH_SMARTY_COPILE)) mkdir(ECOMP_PATH_SMARTY_COPILE);
if(!is_dir(ECOMP_PATH_SMARTY_TEMPLATE)) mkdir(ECOMP_PATH_SMARTY_TEMPLATE);

?>
