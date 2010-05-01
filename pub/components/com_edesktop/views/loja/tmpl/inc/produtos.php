<?
defined('_JEXEC') or die('Restricted access');


?>
<div id="loja-listadepodutos">
	<? if($this->params->get('show_page_title')){ echo '<h2>' .$this->params->get('page_title'). '</h2>'; } ?>

	<? foreach($this->dados as $p):?>
	<div class="produto">
		<?
			$produto = JRoute::_("index.php?option=com_edesktop&view=loja&layout=produto&Itemid={$this->itemid}&id={$p->produto->id}");
			$fabricante = JRoute::_("index.php?option=com_edesktop&view=loja&layout=fabricante&Itemid={$this->itemid}&id={$p->fabricante->id}");
		?>
		<p class="img"><a href="<?= $produto; ?>"><img src="" /></a></p>
		<p class="nome"><a href="<?= $produto; ?>"><?= $p->produto->nome; ?></a></p>
		<p class="fabricante"><a href="<?= $fabricante; ?>"><?= $p->fabricante->nome; ?></a></p>
		<p class="valor">R$ <?= number_format($p->produto->valor, 2, ',', ''); ?></p>
	</div>
	<? endforeach; ?>
</div>