<? defined('_JEXEC') or die('Restricted access'); ?>
<div id="loja-carrinho">
	
	<h1>Meu carrinho de compras</h1>
	
	<? if($this->dados['msg']): ?>
	<div class="msg">
		<h2><?= $this->dados['msg']; ?></h2>
	</div>
	<? endif; ?>
	
	<form id="carrinho" action="<?= JURI::base() . "index.php?option=com_edesktop&view=loja&layout=carrinho&Itemid={$this->itemid}" ?>" method="post">

		<table class="produtos">
			<tr class="head">
				<td colspan="2" class="descr">Descrição do Produto</td>
				<td>Valor Unitário</td>
				<td>Quantidade</td>
				<td>Valor Total</td>
			</tr>
			<? if(!count($this->itens)): ?>
				<tr class="item">
					<td class="erro" colspan="5">Nenhum item foi adicionado no carrinho.</td>
				</tr>
			<? endif; ?>
			
			<?
			foreach($this->itens as $p): 
				$link = "index.php?option=com_edesktop&view=loja&layout=produto&Itemid={$this->itemid}&id={$p['id']}";
			?>
			<tr class="item">
				<td class="img">
				<a class="destaque" rel="lightbox-imgs" href="<?= $p['img']; ?>" tabindex="650,450" style="background: #FFF url([eImage src='<?= $p['img'] ?>' width='80' height='100']) no-repeat center center;" ><img src="<?= $p['img'] ?>" width="80" height="100" /></a></td>
				<td class="descr"><a href="<?= $link; ?>"><?= $p['nome']; ?></a></td>
				<td class="valor">R$ <?= number_format($p['valor'], 2, ',', '.'); ?></td>
				<td class="quant">
					<input type="input" value="<?= $p['quantidade']; ?>" name="qt[<?= $p['key']; ?>]" rel="int_" class="<?= $p['key']; ?>" />
					<a href="javascript:void(0);" class="up"><img src="media/com_edesktop/loja/imagens/btRefresh.gif" /></a>
					<a href="javascript:void(0);" class="rm" rel="<?= $p['key']; ?>"><img src="media/com_edesktop/loja/imagens/btRemove.gif" /></a>
				</td>
				<td class="total">R$ <?= number_format($p['total'], 2, ',', '.'); ?></td>
			</tr>
			<? endforeach; ?>
		</table>

		<? if(count($this->itens)): ?>
		<div class="colLeft">
			
			<div class="frete">
				<h2>Informe o seu CEP</h2>
				<input type="input" value="<?= @$this->dados['frete']['cep1']; ?>" name="cep1" class="cep1" maxlength="5" size="5" /> - 
				<input type="input" value="<?= @$this->dados['frete']['cep2']; ?>" name="cep2" class="cep2" maxlength="3" size="2" />
				<a href="javascript:void(0);" title="Consultar" class="cep"><img src="media/com_edesktop/loja/imagens/icoOk.gif" alt="Consultar" /></a>
				
				<div class="tipos">
					<? if($this->dados['frete']['cep'] && $this->dados['frete']['tipo'] != 'fixo'): ?>			
					<label><input type="radio" value="PAC" name="frete.modo" <?= $this->dados['frete']['modo'] == 'PAC' ? 'checked="checked"' : '';  ?> /><span>PAC: R$ <?= number_format($this->dados['frete']['PAC'], 2, ',', '.'); ?></span></label>				
					<label><input type="radio" value="Sedex" name="frete.modo" <?= $this->dados['frete']['modo'] == 'Sedex' ? 'checked="checked"' : '';  ?> /><span>Sedex: R$ <?= number_format($this->dados['frete']['Sedex'], 2, ',', '.'); ?></span></label>			
					<? endif; ?>
					
					<? if($this->dados['frete']['cep']): ?>			
					<label><span>R$ <?= number_format($this->dados['frete']['valor'], 2, ',', '.'); ?> de frete para todo o Brasil</span></label>				
					<? endif; ?>
				
				</div>
			</div>
		
			<div class="cupomDesconto">
				<h2>Cupom de desconto</h2>
				<input type="input" value="" name="cupom" class="cupom" /> 
				<a href="javascript:void(0);" title="Consultar" class="cupom"><img src="media/com_edesktop/loja/imagens/icoOk.gif" alt="Adicionar" /></a>
			</div>
			
			<a href="<?= "index.php?option=com_edesktop&view=loja&layout=destaques&Itemid={$this->itemid}" ?>" class="continuarComprando">Continuar Comprando</a>
			
		</div>

		<div class="colRight">
			<table class="totais">
				<tr>
					<td class="txt">SUBTOTAL:</td>
					<td class="vlr">R$ <?= number_format($this->dados['subtotal'], 2, ',', '.'); ?></td>
				</tr>
				<? if($this->dados['cupom']['html']): ?>
				<tr class="vDesconto bt">
					<td class="txt">DESCONTO:</td>
					<td class="vlr"><?= $this->dados['cupom']['html']; ?></td>
				</tr>
				<? endif; ?>
				<? if($this->dados['frete']['valor']): ?>
				<tr class="vfrete bt">
					<td class="txt">FRETE:</td>
					<td class="vlr">+ R$ <?= number_format($this->dados['frete']['valor'], 2, ',', '.'); ?></td>
				</tr>
				<? endif; ?>
				<tr class="total">
					<td class="txt">TOTAL:</td>
					<td class="vlr">R$ <?= number_format($this->dados['total'], 2, ',', '.'); ?></td>
				</tr>
			</table>
			
			<? if(count($this->itens)): ?>
			<a href="javascript:void(0);" class="finalizarCompra"><img src="media/com_edesktop/loja/imagens/buttonGoCheckout.gif"></a>
			<? endif; ?>
			
		</div>
		<? endif; ?>

		<br class="clearfix" />
		
		<?php echo JHTML::_( 'form.token' ); ?>
		<input type="hidden" value="update" name="funcao" class="funcao" />
	</form>	
		
</div>