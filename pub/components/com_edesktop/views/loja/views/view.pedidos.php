<?php
	// Altera o titulo
	$_SESSION['eload']['title'] = "Cusulta de pedidos - {sitename}";
	
	
	// carrega o ID da Transação
	$pedido = JRequest::getvar('pedido', false);
	
	// remove os '-'
	$id = str_replace('-', '', $pedido);
	
	// carrega o e-mail
	$email = JRequest::getvar('email', false);
		
	// carrega a class	
	jimport('edesktop.programas.loja.pedidos');
	
	// inicia o obj
	$p = new edesktop_loja_pedidos();
	
	// busca os dados
	$dados = $p->busca_por_transacaoID($id, $email);
	
	// verifica a consulta
	$msg = false;
	if($email && !$dados)
		$msg = true;
		
	// envia os dados
	$this->assignRef('msg', $msg);
	$this->assignRef('dados', $dados);
	$this->assignRef('pedido', $pedido);
	$this->assignRef('email', $email);
	
?>