<?php
// evitar acesso direto
defined('_JEXEC') or die('Acesso restrito');

// carrega o raquivo comum
require_once(JPATH_ROOT.DS.'media'.DS.'com_ecomp'.DS.'comum.php' );

// Carrega a biblioteca
require_once(ECOMP_PATH_CLASS.DS.'ebasic.php' );

// Carrega o helper
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helper.php' );

// Inicia o objeto eBasic
$eBasic =& new eBasic('componentes');

// Inicia o componente
$eBasic->componentStart();
?>
	
