<? defined('_JEXEC') or die('Restricted access'); ?>
<div id="loja-cadastro">
	
	<? 
		if($this->formPagSeguro)
		{
			echo $this->formPagSeguro;
		}
		else
		{
	?>
	
	
	<h1>Cadastro</h1>
	
	<? if($this->msg): ?>
	<div class="msg">
		<h2><?= $this->msg; ?></h2>
	</div>
	<? endif; ?>
	
	<form class="cadastro" action="<?= JRoute::_("index.php?option=com_edesktop&view=loja&layout=cadastro&Itemid={$this->itemid}");?>" method="post">

		<div class="cadastro">
			<h2>Seus dados</h2>
			<label><span>Nome completo:</span><input name="nome" title="Nome completo" type="input" maxlength="100" rel="text_" value="<?= $this->post['nome']; ?>" /></label>
			<label><span>E-mail:</span><input name="email" title="E-mail" type="input" maxlength="255" rel="email_" value="<?= $this->post['email']; ?>" /></label>
			<label class="tel"><span>Telefone:</span><input name="telefone" title="Telefone" type="input" rel="phone_" value="<?= $this->post['telefone']; ?>" /></label>
			<label><span>Observações:</span><textarea name="anotacoes" class="anot"><?= $this->post['anotacoes']; ?></textarea><span class="opcional">opcional</span><span class="limit"></span></label>
			
			<br class="clearfix"/>
			
			<h2 class="mt">Endereço de entrega</h1>
			<label><span>CEP:</span><?= @$this->dados['frete']['cep'] ?><a href="<?= JRoute::_("index.php?option=com_edesktop&view=loja&layout=carrinho&Itemid={$this->itemid}")?>">alterar</a></label>
			<label><span>Endereço:</span><?= $this->dados['cadastro']['tipo_logradouro'] .' '. @$this->dados['cadastro']['logradouro'] ?></label>
			<label><span>Bairro:</span><?= @$this->dados['cadastro']['bairro'] ?></label>
			<label class="num"><span>Número:</span><input name="numero" title="Número" rel="text_" type="input" maxlength="10" value="<?= $this->post['numero']; ?>" /></label>
			<label><span>Cidade:</span><?= @$this->dados['cadastro']['cidade'] ?></label>
			<label class="com"><span>Complemento:</span><input name="complemento" type="input" maxlength="100" value="<?= $this->post['complemento']; ?>" /><span class="opcional">opcional</span></label>
			<label><span>Estado:</span><?= @$this->dados['cadastro']['uf'] ?></label>
		</div>
		
		<div class="btn">
			<a href="javascript:void(0);" class="finalizarCompra"><img src="media/com_edesktop/loja/imagens/buttonGoCheckout.gif"></a>
		</div>
		
		<?php echo JHTML::_( 'form.token' ); ?>
		
	</form>	
	
	
	<? } ?>
	
</div>