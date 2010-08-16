<?
defined('_JEXEC') or die('Restricted access'); 

// dados
$p = $this->dados;

?>
<div id="loja-produto">
	<div class="produto">
	
		<? if($p): ?>
	
		<h1><?= $p->referencia == '' ? $p->nome : "{$p->nome} <span class=\"ref\">(ref. " .strtoupper($p->referencia). ")</span>"; ?></h1>
		
		<div class="imagens">
			<a class="destaque" rel="lightbox-imgs" href="<?= $p->imagem->url ?>" tabindex="650,450" style="background: url([eImage src='<?= $p->imagem->url ?>' width='144' height='180']) no-repeat center center;" title="<?= $p->imagem->nome; ?>"><img src="<?= $p->imagem->url; ?>" width="164" height="200"  alt="<?= $p->imagem->nome ? $p->imagem->nome : $p->nome ; ?>" /></a>
			
			<? foreach($p->Imagens as $i): ?>
			<a rel="lightbox-imgs" href="<?= $i->url ?>" tabindex="650,450" style="background: url([eImage src='<?= $i->url ?>' width='40' height='40']) no-repeat center center;" title="<?= $i->nome; ?>"><img src="<?= $i->url; ?>" width="40" height="40" alt="<?= $i->nome ? $i->nome : $p->nome ; ?>" /></a>
			<? endforeach; ?>
			
			<br class="clearfix" />
		</div>
		
		<div class="dados">
			<p class="descricao"><?= nl2br($p->descricao); ?></p>
			<p class="valor">R$ <?= number_format($p->valor, 2, ',', '.'); ?></p>
			
			<form action="<?= JURI::base(). "index.php?option=com_edesktop&view=loja&layout=carrinho&Itemid={$this->itemid}"; ?>" method="post">

				<?
					$opcoes = json_decode($p->opcoes); 
					if(count($opcoes) && is_array($opcoes))
					{
						foreach($opcoes as $opcao)
						{
							echo '<label class="opcoes">' .$opcao->nome. '<select name="op[]" title="' .$opcao->nome. '" rel="text_">';
							echo '<option value="">-- Selecione --</option>';

							foreach($opcao->itens as $item)
							{
								echo '<option value="' .$item. '">' .$item. '</option>';
							}
							
							echo '</select></label>';
						}
					}	
				?>

				<div class="comprar">
					<input type="submit" value="Comprar" />
				</div>
				<? if($p->referencia): ?>
				<input type="hidden" name="op[Ref]" value="<?= strtoupper($p->referencia) ?>" />
				<? endif; ?>
								
				<input type="hidden" name="id" value="<?= $p->id; ?>" />
				<input type="hidden" name="funcao" value="add" />
				<?= JHTML::_( 'form.token' ); ?>
			</form>
		</div>

		<br class="clearfix" />

		<div class="textos">
			<? foreach($p->Textos as $t): ?>
			<h3><?= $t->titulo; ?></h3>
			<div class="texto"><?= $t->html; ?></div>
			<? endforeach; ?>
		</div>
		<? else: ?>
		<div class="aviso">
			<p>Produto não encontrado!</p>
		</div>
		<? endif; ?>
	</div>
	
</div>