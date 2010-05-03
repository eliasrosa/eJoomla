<?
defined('_JEXEC') or die('Restricted access');


?>
<div id="loja-listadepodutos">
	<? if($this->params->get('show_page_title')){ echo '<h2>' .$this->params->get('page_title'). '</h2>'; } ?>
	
	<!-- Inicio produtos -->
	<? foreach($this->dados as $p):?>
	<div class="produto">
		<?
			$produto = JRoute::_("index.php?option=com_edesktop&view=loja&layout=produto&Itemid={$this->itemid}&id={$p->produto->id}");
			$fabricante = JRoute::_("index.php?option=com_edesktop&view=loja&layout=fabricante&Itemid={$this->itemid}&id={$p->fabricante->id}");
		?>
		<p class="img"><a href="<?= $produto; ?>"><img src="<?= $p->imagem->url ?>" alt="<?= $p->produto->nome; ?> - Produto <?= $p->fabricante->nome; ?> " width="130" height="150" /></a></p>
		<p class="nome"><a href="<?= $produto; ?>"><?= $p->produto->nome; ?></a></p>
		<p class="fabricante"><a href="<?= $fabricante; ?>"><?= $p->fabricante->nome; ?></a></p>
		<p class="valor">R$ <?= number_format($p->produto->valor, 2, ',', ''); ?></p>
	</div>
	<? endforeach; ?>
	<!-- Fim produtos -->
	
	<br class="clearfix"/>
	
	<!-- Inicio paginação -->
	<? if(isset($this->paginacao) && $this->paginacao->paginas >= 2): ?>
	<div id="loja-paginacao" class="result">
		<?= "<p>Encontrado {$this->paginacao->registros} produtos(s) em {$this->paginacao->paginas} páginas</p>
			 <div class=\"paginas\">{$this->paginacao->links}</div>"; ?>
	</div>
	<? endif; ?>
	<!-- Fim paginação -->
	
	<? if(!$this->paginacao->registros): ?>
	<div class="aviso">
		<p>Nenhum produto foi encontrado!</p>
	</div>
	<? endif; ?>
		
</div>