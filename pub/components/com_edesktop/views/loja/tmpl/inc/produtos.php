<?
defined('_JEXEC') or die('Restricted access');
$produtos = $this->dados->pagerLayout->execute();
?>
<div id="loja-listadepodutos">
	
	<? if(isset($this->titulo) && !empty($this->titulo))
		echo "<h1>{$this->titulo}</h1>"; ?>
	
	<? if($this->dados->pager->getNumResults()): ?>
		<div class="order">Ordenar por: <?= $this->dados->getPagerOrder() ?></div>
	<? endif; ?>
	
	<br class="clearfix" />
		
	<!-- Inicio produtos -->
	<? foreach($produtos as $p)
			echo edLoja::getInstance()->getProdutoHtml($p);
	?>
	<!-- Fim produtos -->
	
	<br class="clearfix"/>
	
	<!-- Inicio paginação -->
	<? if($this->dados->pager->getLastPage() > 1): ?>
	<div id="loja-paginacao" class="result">
		<?
			echo '<p>Encontrado ' .$this->dados->pager->getNumResults(). ' produtos em ' .$this->dados->pager->getLastPage(). ' páginas</p><div class="paginas">';
			$this->dados->pagerLayout->display();
			echo '</div>';
		?>
	</div>
	<? elseif($this->dados->pager->getLastPage() < 2 && $this->dados->pager->getNumResults() > 1): ?>
	<div id="loja-paginacao" class="result">
		<?= '<p>Encontrado ' .$this->dados->pager->getNumResults(). ' produtos</p>'; ?>
	</div>
	<? elseif($this->dados->pager->getNumResults() == 1): ?>
	<div id="loja-paginacao" class="result">
		<?= '<p>Encontrado ' .$this->dados->pager->getNumResults(). ' produtos</p>'; ?>
	</div>
	<? endif; ?>
	<!-- Fim paginação -->
	
	<? if($this->dados->pager->getNumResults() == 0): ?>
	<div class="aviso">
		<p>Nenhum produto foi encontrado!</p>
	</div>
	<? endif; ?>
		
</div>