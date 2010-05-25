<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="loja-pedidos">
	<h1>Pedidos</h1>

	<? if($this->dados): ?>
		<div class="result">
			<label>
				<span class="col">E-mail do comprador:</span>
				<span class="txt"><?= $this->email; ?></span>
			</label>
			
			<label>
				<span class="col">Número do pedido:</span>
				<span class="txt"><?= $this->pedido; ?></span>
			</label>
			
			<label>
				<span class="col">Status:</span>
				<span class="txt"><?= $this->dados->statustransacao; ?></span>
			</label>
		</div>
	
	<? else: ?>
	
		<? if($this->msg): ?>
		<div id="loja-msg-erro">
			<h2>Dados inválidos!</h2>
		</div>
		<? endif; ?>

		<p>Consulte o status do seu pedido, preencha os dados abaixo.</p>
		<form method="post" action="">
			<label><span>E-mail do comprador:</span><input class="txt" name="email" type="input" value="atendimento@rosaartes.com.br" /></label>
			<label><span>Número do pedido:</span><input class="txt" name="pedido" type="input" value="441845C6-95A9-4B2E-973F-8649EFC0EE57" /></label>		
			<input name="Consultar" type="submit" class="submit" />
		</form>
	
	<? endif; ?>
</div>