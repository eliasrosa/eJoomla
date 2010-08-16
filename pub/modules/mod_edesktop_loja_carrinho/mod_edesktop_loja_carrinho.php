<?php
defined('_JEXEC') or die( "Acesso Restrito" );


$mid = $params->get('mod_id');
$tit = $params->get('mod_titulo');
$iid = $params->get('mod_itemid');


// adiciona o style css da loja
JHTML::stylesheet('style.css', 'media/com_edesktop/loja/css/');

// busca dados
$itens = @$_SESSION['loja.carrinho.itens'];
$dados = @$_SESSION['loja.carrinho.dados'];

// link do carrinho
$linkCarrinho = "index.php?option=com_edesktop&view=loja&layout=carrinho&Itemid={$iid}";
?>

<div id="<?= $mid ?>" class="modEdesktopLojaCarrinho">
	<?= $module->showtitle ? "<h2>$tit</h2>" : ""; ?>
	<div class="corpo">
		
		<? if(count($itens)): ?>
			<? foreach($itens as $i): ?>
			<a class="itens" href="<?= $linkCarrinho; ?>" title="<?= $i['nome']; ?>">
				<?= $i['nome']; ?> <span class="valor">R$ <?= number_format($i['valor'], 2, ',', '.'); ?></span>		
			</a>
			<? endforeach; ?>
			<div class="subtotal">
				<span class="txt">subtotal:</span>
				<span class="valor">RS <?= number_format($dados['subtotal'], 2, ',', '.'); ?></span>
				<br class="clearfix" />
			</div>
		<? else: ?>
			<p class="vazio">Nenhum item foi adicionado no carrinho</p>
		<? endif; ?>
		<a class="visualizar" title="Visualizar carrinho" href="<?= $linkCarrinho; ?>">Visualizar carrinho</a>		
	</div>
</div>
