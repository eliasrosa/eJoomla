<?
defined('_JEXEC') or die('Restricted access'); 

// dados
$p = $this->dados;

?>
<div id="loja-produto">
	<div class="produto">
	
		<h1><?= $p->produto->referencia == '' ? $p->produto->nome : "{$p->produto->nome} <span class=\"ref\">(ref. " .strtoupper($p->produto->referencia). ")</span>"; ?></h1>
		
		<div class="imagens">
			<a class="destaque" rel="lightbox-imgs" href="<?= $p->imagem->url ?>" tabindex="650,450" style="background: url([eImage src='<?= $p->imagem->url ?>' width='144' height='180']) no-repeat center center;" title="<?= $p->imagem->nome; ?>"><img src="<?= $p->imagem->url; ?>" width="164" height="200"  alt="<?= $p->imagem->nome ? $p->imagem->nome : $p->produto->nome ; ?>" /></a>
			
			<? foreach($p->imagens as $i): ?>
			<a rel="lightbox-imgs" href="<?= $i->url ?>" tabindex="650,450" style="background: url([eImage src='<?= $i->url ?>' width='40' height='40']) no-repeat center center;" title="<?= $i->nome; ?>"><img src="<?= $i->url; ?>" width="40" height="40" alt="<?= $i->nome ? $i->nome : $p->produto->nome ; ?>" /></a>
			<? endforeach; ?>
			
			<br class="clearfix" />
		</div>
		
		<div class="dados">
			<p class="descricao"><?= nl2br($p->produto->descricao); ?></p>
			<p class="valor">R$ <?= number_format($p->produto->valor, 2, ',', '.'); ?></p>
			
			<form action="<?= JRoute::_("index.php?option=com_edesktop&view=loja&layout=carrinho&Itemid={$this->itemid}"); ?>" method="post">
				<div class="comprar">
					<input type="submit" value="Comprar" />
				</div>
				<? if($p->produto->referencia): ?>
				<input type="hidden" name="op[Ref]" value="<?= strtoupper($p->produto->referencia) ?>" />
				<? endif; ?>
				
				<input type="hidden" name="id" value="<?= $p->produto->id; ?>" />
				<input type="hidden" name="funcao" value="add" />
				<?= JHTML::_( 'form.token' ); ?>
			</form>
		</div>

		<br class="clearfix" />

		<div class="textos">
			<? foreach($p->textos as $t): ?>
			<h3><?= $t->titulo; ?></h3>
			<div class="texto"><?= $t->html; ?></div>
			<? endforeach; ?>
		</div>
		
	</div>
	
</div>