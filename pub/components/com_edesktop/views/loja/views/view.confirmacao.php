<?php
	// carrega o mainframe
	global $mainframe;
	
	
	// Altera o titulo
	$_SESSION['eload']['title'] = "{sitename} - Obrigado!";


	// nome das sessões
	//$sessao_itens = 'loja.carrinho.itens';
	//$sessao_dados = 'loja.carrinho.dados';
	//unset($_SESSION[$sessao_itens], $_SESSION[$sessao_dados]);

	// remove a session
	session_destroy();


	// token do pagseguro
	define('PAGSEGURO_TOKEN', $this->config->get('pagSeguroToken'));
	
	
	// Função que captura os dados do retorno
	function retorno_automatico ( $VendedorEmail, $TransacaoID,
	  $Referencia, $TipoFrete, $ValorFrete, $Anotacao, $DataTransacao,
	  $TipoPagamento, $StatusTransacao, $CliNome, $CliEmail,
	  $CliEndereco, $CliNumero, $CliComplemento, $CliBairro, $CliCidade,
	  $CliEstado, $CliCEP, $CliTelefone, $produtos, $NumItens) {


		// abre a class
		jimport('edesktop.programas.loja.pedidos');
		$pedido = new edesktop_loja_pedidos();	
	
			
		// corrige a data
		list($data, $hora) = explode(' ', $DataTransacao);
		$data = explode('/', $data);
		$data = $data['2'] .'/'. $data['1'] .'/'. $data['0'];
		$DataTransacao = $data .' '. $hora;
		

		$dadosPedido = array( 
			'id' => $Referencia,
			'TransacaoID' => $TransacaoID,
			'Extras' => $Extras,
			'DataTransacao' => $DataTransacao,
			'TipoPagamento' => $TipoPagamento,
			'StatusTransacao' => $StatusTransacao
		);
		
		
		// cadastra o pedido
		$pedido->salvar($dadosPedido);

	}
	
	// carrega o arquivo de retorno do pagseguro
	jimport('edesktop.pagseguro.retorno');
	
	
		
?>
