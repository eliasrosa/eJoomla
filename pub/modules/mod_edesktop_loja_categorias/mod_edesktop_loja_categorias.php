<?php
defined('_JEXEC') or die( "Acesso Restrito" );

// carrega a class
jimport('edesktop.programas.loja');

// Abre o helper
require_once ('helper.php');

//
$doc  = & JFactory::getDocument();

// adiciona o style css da loja
$doc->addStyleSheet('media/com_edesktop/loja/mods/modEdesktopLojaCategorias/style.css');

// adiciona o script
$doc->addScript('media/com_edesktop/loja/mods/modEdesktopLojaCategorias/comum.js');


$mid = $params->get('mod_id');
$tit = $params->get('mod_titulo');


echo "<div id=\"$mid\" class=\"modEdesktopLojaCategorias\">";
echo $module->showtitle ? "<h2>$tit</h2>" : "";
new modEdesktopLojaCategoriasHelper();
echo "</div>";

?>