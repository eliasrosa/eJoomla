<?php
defined('_JEXEC') or die( "Acesso Restrito" );


$mid = $params->get('mod_id');
$tit = $params->get('mod_titulo');
$iid = $params->get('mod_itemid');

// carrega o busca
$busca = JRequest::getvar('q', '');
?>

<div id="<?= $mid ?>" class="modEdesktopProdutosBusca">
	<form method="get" action="<?= JURI::base() . "index.php?option=com_edesktop&view=loja&layout=busca&Itemid={$iid}" ?>">
		<?= $module->showtitle ? "<h2>$tit</h2>" : ""; ?>
		<input name="q" value="<?= $busca; ?>" type="input" class="text" />
		<input value="Buscar" type="submit" class="submit" />
	</form>
</div>
