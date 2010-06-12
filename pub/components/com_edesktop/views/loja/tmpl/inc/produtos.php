<?
defined('_JEXEC') or die('Restricted access');


?>
<div id="loja-listadepodutos">
	<? if($this->params->get('show_page_title')){ echo '<h2>' .$this->params->get('page_title'). '</h2>'; } ?>
	
	<!-- Inicio produtos -->
	<? foreach($this->dados as $p):?>
	<div class="produto">
		<?
			$p->produto->nome = mb_convert_case($p->produto->nome, MB_CASE_TITLE, "UTF-8");
			$produto = JRoute::_("index.php?option=com_edesktop&view=loja&layout=produto&Itemid={$this->itemid}&id={$p->produto->id}");
			
			if($p->produto->idfabricante)
				$fabricante = @JRoute::_("index.php?option=com_edesktop&view=loja&layout=fabricante&Itemid={$this->itemid}&id={$p->fabricante->id}");

		?>
		<p class="img"><a href="<?= $produto; ?>"><img src="<?= $p->imagem->url ?>" alt="<?= $p->produto->nome; ?> - Produto <?= $p->fabricante->nome; ?> " width="130" height="150" /></a></p>
		<p class="nome"><a href="<?= $produto; ?>"><?= $p->produto->nome; ?></a></p>
		
		<? if($p->produto->idfabricante): ?>
		<p class="fabricante"><a href="<?= $fabricante; ?>"><?= $p->fabricante->nome; ?></a></p>
		<? endif; ?>
		
		<p class="valor">R$ <?= number_format($p->produto->valor, 2, ',', '.'); ?></p>
	</div>
	<? endforeach; ?>
	<!-- Fim produtos -->
	
	<br class="clearfix"/>
	
	<!-- Inicio paginação -->
	<? if($this->paginacao->paginas >= 2): ?>
	<div id="loja-paginacao" class="result">
		<?= "<p>Encontrado {$this->paginacao->registros} produtos em {$this->paginacao->paginas} páginas</p>
			 <div class=\"paginas\">{$this->paginacao->links}</div>"; ?>
	</div>
	<? elseif($this->paginacao->registros > 1): ?>
	<div id="loja-paginacao" class="result">
		<?= "<p>Encontrado {$this->paginacao->registros} produtos</p>"; ?>
	</div>
	<? elseif($this->paginacao->registros == 1): ?>
	<div id="loja-paginacao" class="result">
		<?= "<p>Encontrado {$this->paginacao->registros} produto</p>"; ?>
	</div>
	<? endif; ?>
	<!-- Fim paginação -->
	
	<? if(!$this->paginacao->registros): ?>
	<div class="aviso">
		<p>Nenhum produto foi encontrado!</p>
	</div>
	<? endif; ?>
		
</div>