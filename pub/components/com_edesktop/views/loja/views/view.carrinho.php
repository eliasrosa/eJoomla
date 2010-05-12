<?php
	// carrega o mainframe
	global $mainframe;


	
	// cria o link do carrinho com route
	$link = JRoute::_("index.php?option=com_edesktop&view=loja&layout=carrinho&Itemid={$this->itemid}");


	
	// Altera o titulo
	$_SESSION['eload']['title'] = "Carrinho de compras - {sitename}";


			
	// Carrega a função
	$funcao = JRequest::getvar('funcao', false);	
	
	
	
	// checa o token dos envios de dados
	if($funcao)
		JRequest::checkToken() or die('Invalid Token');


	
	// nome das sessões
	$sessao_itens = 'loja.carrinho.itens';
	$sessao_dados = 'loja.carrinho.dados';



	// carrega a session
	if(isset($_SESSION[$sessao_itens]) || isset($_SESSION[$sessao_dados]))
	{
		$itens = $_SESSION[$sessao_itens];
		$dados = $_SESSION[$sessao_dados];
	}
	else
		$itens = $dados = array();

	
	
	// cupons
	if(!isset($dados['cupom']))
	{
		$dados['cupom'] = array(
			'valor' => 0,
			'code' => '',
			'html' => '',
			'tipo' => ''
		);
	}
	
	
	
	// frete
	if(!isset($dados['frete']))
	{
		$dados['frete'] = array(
			'valor' => '',
			'peso' => 0,
			'PAC' => 0,
			'Sedex' => 0,
			'cep' => '',
			'modo' => 'PAC',
			'tipo' => $this->config->get('freteTipo')
		);
	}



	// mod do frete PAC ou Sedex
	if(JRequest::getvar('frete.modo'))
		$freteModo = $dados['frete']['modo'] = JRequest::getvar('frete.modo', 'PAC');




	/* ***************************************
	 * Consulta cep
	 * ***************************************/
 	if($funcao == 'cep')
	{
		// pega o cep
		$cep1 = JRequest::getvar('cep1', 0, 'post');
		$cep2 = JRequest::getvar('cep2', 0, 'post');
		$cep = "{$cep1}-{$cep2}";
		
		// reseta o dados do frete
		$dados['frete']['PAC'] = 0;
		$dados['frete']['Sedex'] = 0;
		$dados['frete']['cep'] = '';
		$dados['frete']['cep1'] = '';
		$dados['frete']['cep2'] = '';
		
		// se o cep for valido
		if(preg_match('/(^\d{5}-\d{3}$)/', $cep))
		{
			$dados['frete']['cep'] = $cep;
			$dados['frete']['cep1'] = $cep1;
			$dados['frete']['cep2'] = $cep2;
		}		
	}
	
	
	
	
	/* ***************************************
	 * Adiciona produto no carrinho
	 * ***************************************/
	if($funcao == 'add')
	{
		// busca o produto
		$p = $this->carrinho_busca_produto();
		
		// adiciona o produto na sessao
		$itens[$p->carrinho->id] = array(
			'key' => $p->carrinho->id,
			'id' => $p->db->id,
			'img' => $p->db->imagem,
			'nome' => $p->carrinho->nome,
			'valor' => $p->db->valor,
			'peso' => $p->db->peso,
			'frete' => $p->db->frete,
			'quantidade' => 1
		);					
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
			$dados['cupom']['id'] = $cupom->id;
			$dados['cupom']['code'] = strtoupper($cupom->codigo);
			$dados['cupom']['valor'] = $cupom->valor;
			$dados['cupom']['tipo'] = $cupom->tipo;
		
			if($cupom->tipo == '$')
				$dados['cupom']['html'] = "- R$ " .number_format($cupom->valor, 2, ',', '');

		}					
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
				unset($itens[$k]);
			else
				// atualiza as quantidades
				$itens[$k]['quantidade'] = $qt;
		}			
	}
	



	/* ***************************************
	 * Se for uma funcao
	 * ***************************************/
	if($funcao)
	{	
		// atualiza as sessions
		$_SESSION[$sessao_itens] = $itens;
		$_SESSION[$sessao_dados] = $dados;		
				
		// redireciona para o carrinho
		$mainframe->redirect($link);			
	}
	
	

	// adiciona o javascript do carrinho
	JHTML::script('carrinho.js', 'media/com_edesktop/loja/js/');


	
	//zera os dados
	$dados['subtotal'] = 0;
	$dados['frete']['peso'] = 0;
	
	
	
	// Recalcula o valores dos itens
	foreach($itens as $id => $item)
	{
		$dados['frete']['peso'] = $dados['frete']['peso'] + ($item['peso'] * $item['quantidade']);
		$itens[$id]['total'] = $item['valor'] * $item['quantidade'];
		$dados['subtotal'] = $dados['subtotal'] + $itens[$id]['total'];
	}




	/* ***************************************
	 * FRETE - valor fixo no carrinho
	 * ***************************************/
	if($dados['frete']['tipo'] == 'fixo' && $dados['frete']['valor'] == 0)
	{
		$dados['frete']['valor'] = $this->config->get('freteValor');
	}




	/* ***************************************
	 * FRETE - valor por peso X quantidade
	 * ***************************************/
	if($dados['frete']['valor'] == 'produto' && preg_match('/(^\d{5}-\d{3}$)/', $dados['frete']['cep']))
	{	
		jimport('edesktop.pagseguro.frete');
		
		$dados['frete']['peso'] = ceil($dados['frete']['peso'] / 1000);
		
		// consulta
		$frete = new PgsFrete();
		$dados['fretes'] = $frete->gerar($this->config->get('cepOrigem'), $dados['frete']['peso'], 0, $dados['cep']);

		//  
		if(isset($dados['fretes']['PAC']) || isset($dados['fretes']['Sedex']))
		{
			$dados['fretes']['PAC'] = str_replace(',', '.', $dados['fretes']['PAC']);	
			$dados['fretes']['Sedex'] = str_replace(',', '.', $dados['fretes']['Sedex']);	
		}
		else
		{
			$dados['fretes'] = array('PAC' => 0, 'Sedex' => 0);
		}
		
		$dados['freteValor'] = $dados['fretes'][$freteModo];
	}
	


	// soma o valor
	$dados['total'] = ($dados['subtotal'] + $dados['frete']['valor']);
	

	
	// descontos do tipo $
	if($dados['cupom']['tipo'] == '$')
		$dados['total'] = $dados['total'] - $dados['cupom']['valor'];



	// descontos do tipo %
	if($dados['cupom']['tipo'] == '%')
	{
		$cupomPorce = $dados['cupom']['valor'];
		$cupomValor = $dados['total'] * ($dados['cupom']['valor'] / 100);
		
		$dados['cupom']['html'] = "(-{$cupomPorce}%) R$ " .number_format($cupomValor, 2, ',', '');
		$dados['total'] = $dados['total'] - $cupomValor;
	}


	if($dados['cupom']['html'] == '')
		$dados['cupom']['html'] = '- R$ 0,00';



	// atualiza as sessions
	$_SESSION[$sessao_itens] = $itens;
	$_SESSION[$sessao_dados] = $dados;



	// envia para o layout
	$this->assignRef('itens', $itens);
	$this->assignRef('dados', $dados);



	//print_r($itens);

?>