<? defined('_JEXEC') or die('Restricted access'); ?>
<div id="loja-listadepodutos">
	
	<? if(isset($this->titulo) && !empty($this->titulo))
		echo "<h1>{$this->titulo}</h1>"; ?>
	
	<? if($this->paginacao->total_registros >= 1): ?>
	<div class="order">Ordenar por: <?= $this->paginacao->html['order.select']; ?></div>
	<? endif; ?>
	
	<br class="clearfix" />
		
	<!-- Inicio produtos -->
	<? foreach($this->dados as $p):?>
	<div class="produto">
		<?
			$produto = JRoute::_("index.php?option=com_edesktop&view=loja&layout=produto&Itemid={$this->itemid}&id={$p->produto->id}");
			$fabricanteALT = "";
			
			if($p->produto->idfabricante)
			{
				$fabricante = JRoute::_("index.php?option=com_edesktop&view=loja&layout=fabricante&Itemid={$this->itemid}&id={$p->fabricante->id}");
				$fabricanteALT = "- Produto {$p->fabricante->nome}";
			}
		?>
		<p class="img"><a href="<?= $produto; ?>"><img src="<?= $p->imagem->url ?>" alt="<?= $p->produto->nome; ?> <?= $fabricanteALT ?> " width="130" height="150" /></a></p>
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
	<? if($this->paginacao->total_paginas >= 2): ?>
	<div id="loja-paginacao" class="result">
		<?= "<p>Encontrado {$this->paginacao->total_registros} produtos em {$this->paginacao->total_paginas} páginas</p>
			 <div class=\"paginas\">{$this->paginacao->html['paginas.select']}</div>"; ?>
	</div>
	<? elseif($this->paginacao->total_registros > 1): ?>
	<div id="loja-paginacao" class="result">
		<?= "<p>Encontrado {$this->paginacao->total_registros} produtos</p>"; ?>
	</div>
	<? elseif($this->paginacao->total_registros == 1): ?>
	<div id="loja-paginacao" class="result">
		<?= "<p>Encontrado {$this->paginacao->total_registros} produto</p>"; ?>
	</div>
	<? endif; ?>
	<!-- Fim paginação -->
	
	<? if(!$this->paginacao->total_registros): ?>
	<div class="aviso">
		<p>Nenhum produto foi encontrado!</p>
	</div>
	<? endif; ?>
		
</div>