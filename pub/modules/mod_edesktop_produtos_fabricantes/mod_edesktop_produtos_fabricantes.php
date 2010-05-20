<?php
defined('_JEXEC') or die( "Acesso Restrito" );


$mid = $params->get('mod_id');
$tit = $params->get('mod_titulo');
$iid = $params->get('mod_itemid');
$lim = $params->get('mod_limit');


$doc  = & JFactory::getDocument();

// adiciona o style css da loja
$doc->addStyleSheet('media/com_edesktop/loja/mods/modEdesktopProdutosFabricantes/style.css');


// importa a class produtos
jimport('edesktop.programas.produtos.fabricantes');

// inicia o obj
$db = new edesktop_produtos_fabricantes();

// busca dados
$dados = $db->busca_todos($lim);
?>

<div id="<?= $mid ?>" class="modEdesktopProdutosFabricantes">
	<?= $module->showtitle ? "<h2>$tit</h2>" : ""; ?>
	<div class="fabricantes">
		<? foreach($dados as $f): ?>
		<a href="<?= JRoute::_("index.php?option=com_edesktop&view=loja&layout=fabricante&Itemid={$iid}&id={$f->id}")?>">
			<img src="<?= $f->imagem; ?>" alt="<?= $f->nome; ?>" width="150" height="100" />
		</a>
		<? endforeach; ?>
	</div>
</div>
