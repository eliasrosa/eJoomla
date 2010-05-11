<?php
	// carrega o mainframe
	global $mainframe;
	
	// cria o link do carrinho com route
	$link = JRoute::_("index.php?option=com_edesktop&view=loja&layout=carrinho&Itemid={$this->itemid}");
	
	// Altera o titulo
	$_SESSION['eload']['title'] = "Carrinho de compras - {sitename}";
			
	// Carrega a função
	$funcao = JRequest::getvar('funcao', false);	
	if($funcao)
		JRequest::checkToken() or die('Invalid Token');

	// Nome da session
	$itens = 'loja.carrinho.itens';
	$dados = 'loja.carrinho.dados';
	
	// criar a session caso não exita
	if(!isset($_SESSION[$itens]))
		$_SESSION[$itens] = array();
	
	// criar a session caso não exita
	if(!isset($_SESSION[$dados]))
		$_SESSION[$dados] = array();
	
	// criar a session caso não exita
	if(!isset($_SESSION[$dados]['cupom']))
		$_SESSION[$dados]['cupom'] = array('valor' => 0, 'code' => '', 'html' => '', 'tipo' => '');
	
	// criar a session caso não exita
	if(!isset($_SESSION[$dados]['freteValor']))
		$_SESSION[$dados]['freteValor'] = 0;

	// criar a session caso não exita
	if(!isset($_SESSION[$dados]['fretes']['PAC']) || !isset($_SESSION[$dados]['fretes']['Sedex']))
		$_SESSION[$dados]['fretes'] = array('PAC' => 0, 'Sedex' => 0);

	// frete
	if(!isset($_SESSION[$dados]['cep']))
		$_SESSION[$dados]['cep'] = '';
	
	// modo do frete
	if(!isset($_SESSION[$dados]['freteModo']))
		$freteModo = $_SESSION[$dados]['freteModo'] = JRequest::getvar('freteModo', 'PAC');

	// mod do frete PAC ou Sedex
	if(JRequest::getvar('freteModo'))
		$freteModo = $_SESSION[$dados]['freteModo'] = JRequest::getvar('freteModo', 'PAC');

	// tipo do frete
	if(!isset($_SESSION[$dados]['freteTipo']))
		$freteTipo = $_SESSION[$dados]['freteTipo'] = $this->config->get('freteTipo');





	/* ***************************************
	 * Consulta cep
	 * ***************************************/
 	if($funcao == 'cep')
	{
		// pega o cep
		$cep1 = JRequest::getvar('cep1', 0, 'post', 'INT');
		$cep2 = JRequest::getvar('cep2', 0, 'post', 'INT');
		$cep = "{$cep1}-{$cep2}";
		
		if(preg_match('/(^\d{5}-\d{3}$)/', $cep))
		{
			$_SESSION[$dados]['cep'] = $cep;
			$_SESSION[$dados]['cep1'] = $cep1;
			$_SESSION[$dados]['cep2'] = $cep2;
		}
		else
		{
			$_SESSION[$dados]['fretes'] = array('PAC' => 0, 'Sedex' => 0);
			$_SESSION[$dados]['cep'] = '';
			$_SESSION[$dados]['cep1'] = '';
			$_SESSION[$dados]['cep2'] = '';
		}		

		// redireciona para o carrinho
		$mainframe->redirect($link);			
	}
	
	
	
	
	
	/* ***************************************
	 * Adiciona produto no carrinho
	 * ***************************************/
	if($funcao == 'add')
	{
		// busca o produto
		$p = $this->carrinho_busca_produto();
		
		// adiciona o produto na sessao
		$_SESSION[$itens][$p->carrinho->id] = array(
			'key' => $p->carrinho->id,
			'id' => $p->db->id,
			'img' => $p->db->imagem,
			'nome' => $p->carrinho->nome,
			'valor' => $p->db->valor,
			'peso' => $p->db->peso,
			'frete' => $p->db->frete,
			'quantidade' => 1
		);

		// redireciona para o carrinho
		$mainframe->redirect($link);					
	}




	/* ***************************************
	 * Adiciona cupom de desconto
	 * ***************************************/
	if($funcao == 'cupom')
	{
		// carrega a class de cupons
		jimport('edesktop.programas.loja.cupons');
		
		// inici o obj
		$cupom = new edesktop_loja_cupons();
		
		// busca o cupom
		$cupom = $cupom->busca(JRequest::getvar('cupom', ''));
		
		if($cupom)
		{		
			$_SESSION[$dados]['cupom']['id'] = $cupom->id;
			$_SESSION[$dados]['cupom']['code'] = strtoupper($cupom->codigo);
			$_SESSION[$dados]['cupom']['valor'] = $cupom->valor;
			$_SESSION[$dados]['cupom']['tipo'] = $cupom->tipo;
		
			if($cupom->tipo == '$')
				$_SESSION[$dados]['cupom']['html'] = "- R$ " .number_format($cupom->valor, 2, ',', '');

		}

		// redireciona para o carrinho
		$mainframe->redirect($link);					
	}




	/* ***************************************
	 * Atualiza itens do carrinho
	 * ***************************************/
	if($funcao == 'update')
	{			
		foreach(JRequest::getvar('qt', array()) as $k=>$qt)
		{
			$qt = preg_match('/^\d+$/', $qt) ? $qt : 1;
			
			if($qt == 0)
				// remove um item do carrinho
				unset($_SESSION[$itens][$k]);
			else
				// atualiza as quantidades
				$_SESSION[$itens][$k]['quantidade'] = $qt;
		}
		
		// redireciona para o carrinho
		$mainframe->redirect($link);			
	}
	


	// adiciona o javascript do carrinho
	JHTML::script('carrinho.js', 'media/com_edesktop/loja/js/');

	
	//zera os dados
	$_SESSION[$dados]['subtotal'] = 0;
	$_SESSION[$dados]['peso'] = 0;
	
	
	
	// Recalcula o valores dos itens
	foreach($_SESSION[$itens] as $id => $item)
	{
		$_SESSION[$dados]['peso'] = $_SESSION[$dados]['peso'] + ($item['peso'] * $item['quantidade']);
		$_SESSION[$itens][$id]['total'] = $item['valor'] * $item['quantidade'];
		$_SESSION[$dados]['subtotal'] = $_SESSION[$dados]['subtotal'] + $_SESSION[$itens][$id]['total'];
	}



	/* ***************************************
	 * FRETE - valor fixo no carrinho
	 * ***************************************/
	if($_SESSION[$dados]['freteTipo'] == 'fixo' && preg_match('/(^\d{5}-\d{3}$)/', $_SESSION[$dados]['cep']))
	{
		$_SESSION[$dados]['freteValor'] = $_SESSION[$dados]['fretes']['PAC'] = $this->config->get('freteValor');
	}




	/* ***************************************
	 * FRETE - valor por peso X quantidade
	 * ***************************************/
	if($_SESSION[$dados]['freteValor'] == 'produto' && preg_match('/(^\d{5}-\d{3}$)/', $_SESSION[$dados]['cep']))
	{	
		jimport('edesktop.pagseguro.frete');
		
		$_SESSION[$dados]['peso'] = ceil($_SESSION[$dados]['peso'] / 1000);
		
		// consulta
		$frete = new PgsFrete();
		$_SESSION[$dados]['fretes'] = $frete->gerar($this->config->get('cepOrigem'), $_SESSION[$dados]['peso'], 0, $_SESSION[$dados]['cep']);

		//  
		if(isset($_SESSION[$dados]['fretes']['PAC']) || isset($_SESSION[$dados]['fretes']['Sedex']))
		{
			$_SESSION[$dados]['fretes']['PAC'] = str_replace(',', '.', $_SESSION[$dados]['fretes']['PAC']);	
			$_SESSION[$dados]['fretes']['Sedex'] = str_replace(',', '.', $_SESSION[$dados]['fretes']['Sedex']);	
		}
		else
		{
			$_SESSION[$dados]['fretes'] = array('PAC' => 0, 'Sedex' => 0);
		}
		
		$_SESSION[$dados]['freteValor'] = $_SESSION[$dados]['fretes'][$freteModo];
	}
	

	// soma o valor
	$_SESSION[$dados]['total'] = ($_SESSION[$dados]['subtotal'] + $_SESSION[$dados]['freteValor']);
	
	
	
	if($_SESSION[$dados]['cupom']['tipo'] == '$')
		$_SESSION[$dados]['total'] = $_SESSION[$dados]['total'] - $_SESSION[$dados]['cupom']['valor'];



	if($_SESSION[$dados]['cupom']['tipo'] == '%')
	{
		$cupomPorce = $_SESSION[$dados]['cupom']['valor'];
		$cupomValor = $_SESSION[$dados]['total'] * ($_SESSION[$dados]['cupom']['valor'] / 100);
		
		$_SESSION[$dados]['cupom']['html'] = "(-{$cupomPorce}%) R$ " .number_format($cupomValor, 2, ',', '');
		$_SESSION[$dados]['total'] = $_SESSION[$dados]['total'] - $cupomValor;
	}


	// envia para o layout
	$this->assignRef('produtos', $_SESSION[$itens]);
	$this->assignRef('carrinho', $_SESSION[$dados]);

	print_r($_SESSION[$dados]);

?>