<?php
defined('_JEXEC') or die( "Acesso Restrito" );

// importa a class loja
jimport('edesktop.programas.loja');

$mid = $params->get('mod_id');
$tit = $params->get('mod_titulo');
$lim = $params->get('mod_limit');

$imgw = $params->get('mod_img_limit_width');
$imgh = $params->get('mod_img_limit_height');

$iid = edLoja::getInstance()->itemid;

// inicia o obj
$dados = edProdutos::getInstance()
			->busca_todos_fabricantes_ativos();

$dados = $dados->query
			->orderBy('nome ASC')
			->limit($lim)
			->execute();
?>

<div id="<?= $mid ?>" class="modEdesktopLojaFabricantes">
	<?= $module->showtitle ? "<h2>$tit</h2>" : ""; ?>
	<div class="fabricantes">
		<? foreach($dados as $f): ?>
		<a href="<?= "index.php?option=com_edesktop&view=loja&layout=fabricante&Itemid={$iid}&id={$f->id}" ?>">
			<img src="<?= $f->url; ?>" alt="<?= $f->nome; ?>" width="<?= $imgw; ?>" height="<?= $imgh; ?>" />
		</a>
		<? endforeach; ?>
	</div>
</div>
