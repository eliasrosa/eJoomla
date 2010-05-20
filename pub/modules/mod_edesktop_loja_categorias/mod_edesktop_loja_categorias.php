<?php
defined('_JEXEC') or die( "Acesso Restrito" );

// Abre o helper
require_once (dirname(__FILE__).DS.'helper.php');

$doc  = & JFactory::getDocument();

// adiciona o style css da loja
$doc->addStyleSheet('media/com_edesktop/loja/mods/modEdesktopLojaCategorias/style.css');


// adiciona o script
$doc->addScript('media/com_edesktop/loja/mods/modEdesktopLojaCategorias/comum.js');


$mid = $params->get('mod_id');
$tit = $params->get('mod_titulo');
$iid = $params->get('mod_itemid');

echo "<div id=\"$mid\" class=\"modEdesktopLojaCategorias\">";
echo $module->showtitle ? "<h2>$tit</h2>" : "";
echo modEdesktopLojaCategoriasHelper::montaMenu(0, $iid);
echo "</div>";

?>