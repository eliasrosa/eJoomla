<?php
defined('_JEXEC') or die( "Acesso Restrito" );

$mid = $params->get('mod_id');
$tit = $params->get('mod_titulo');
$iid = $params->get('mod_itemid');

$cid = $params->get('mod_categoriaID');
$lim = $params->get('mod_limit');

// adiciona o style css da loja
JHTML::stylesheet('style.css', 'media/com_edesktop/loja/css/');

// importa a class produtos
jimport('edesktop.programas.produtos');

// inicia o obj
$p = new edProdutos();

// busca dados
$dados = $p->busca_produtos_por_categoria($cid, "AND status = '1' AND valor > 0 ORDER BY RAND() LIMIT 0, {$lim}", array('fabricante', 'imagem'));
?>

<div id="<?= $mid ?>" class="modEdesktopProduto">
	<?= $module->showtitle ? "<h2>$tit</h2>" : ""; ?>
	
	<div class="produtos">
		<? foreach($dados as $p):?>
		<div class="produto">
			<?
				$produto = JRoute::_("index.php?option=com_edesktop&view=loja&layout=produto&Itemid={$iid}&id={$p->produto->id}");
				$fabricante = JRoute::_("index.php?option=com_edesktop&view=loja&layout=fabricante&Itemid={$iid}&id={$p->fabricante->id}");
			?>
			<p class="img"><a href="<?= $produto; ?>"><img src="<?= $p->imagem->url ?>" alt="<?= $p->produto->nome; ?> - Produto <?= $p->fabricante->nome; ?> " width="130" height="150" /></a></p>
			<p class="nome"><a href="<?= $produto; ?>"><?= $p->produto->nome; ?></a></p>
			<p class="fabricante"><a href="<?= $fabricante; ?>"><?= $p->fabricante->nome; ?></a></p>
			<p class="valor">R$ <?= number_format($p->produto->valor, 2, ',', ''); ?></p>
		</div>
		<? endforeach; ?>
	</div>
</div>
