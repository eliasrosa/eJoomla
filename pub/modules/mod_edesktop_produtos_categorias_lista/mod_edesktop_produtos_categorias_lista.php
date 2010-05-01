<?php
defined('_JEXEC') or die( "Acesso Restrito" );

// Abre o helper
require_once (dirname(__FILE__).DS.'helper.php');

$mid = $params->get('mod_id');
$tit = $params->get('mod_titulo');
$iid = $params->get('mod_itemid');

echo "<div id=\"$mid\" class=\"modEdesktopProdutosCategoriasLista\">";
echo $module->showtitle ? "<h2>$tit</h2>" : "";
echo modEdesktopProdutosCategoriasListaHelper::montaMenu(0, $iid);
echo "</div>";
?>
