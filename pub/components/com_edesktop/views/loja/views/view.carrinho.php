<?php
	// carrega o mainframe
	global $mainframe;


	
	// cria o link do carrinho com route
	$link = "index.php?option=com_edesktop&view=loja&layout=carrinho&Itemid={$this->itemid}";


	
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
	{
		$itens = array();
		$dados = array(
			'msg' => '',
			'descontoValor' => 0
		);
	}
	
	
	// cupons
	if(!isset($dados['cupom']))
	{
		$dados['cupom'] = array(
			'id' => 0,
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
		$dados['frete']['valor'] = 0;
		$dados['frete']['PAC'] = 0;
		$dados['frete']['Sedex'] = 0;
		$dados['frete']['cep'] = '';
		$dados['frete']['cep1'] = '';
		$dados['frete']['cep2'] = '';
		
		$dados['cadastro'] = array();
		
		// remove a msg de erro
		$dados['msg'] = '';
		
		
		// se o cep for valido
		if(preg_match('/(^\d{5}-\d{3}$)/', $cep))
		{
			$resultado = @file_get_contents('http://cep.republicavirtual.com.br/web_cep.php?cep='.urlencode($cep1.$cep2).'&formato=query_string');  
					
			if(!$resultado)
				$resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";  
			
			parse_str($resultado, $retorno);   

			if($retorno['resultado'])
			{
				$retorno['tipo_logradouro'] = iconv('iso-8859-1', 'utf-8', $retorno['tipo_logradouro']);
				$retorno['logradouro'] = iconv('iso-8859-1', 'utf-8', $retorno['logradouro']);
				$retorno['bairro'] = iconv('iso-8859-1', 'utf-8', $retorno['bairro']);
				$retorno['cidade'] = iconv('iso-8859-1', 'utf-8', $retorno['cidade']);
				$retorno['uf'] = iconv('iso-8859-1', 'utf-8', $retorno['uf']);
				
				$dados['frete']['cep'] = $cep;
				$dados['frete']['cep1'] = $cep1;
				$dados['frete']['cep2'] = $cep2;

				$dados['cadastro'] = $retorno;
				
				$dados['msg'] = '';
			}else
				$dados['msg'] = 'O número do CEP não está correto.';
				
		}else
			$dados['msg'] = 'O número do CEP não está correto.';
	}
	
	
	
	
	/* ***************************************
	 * Adiciona produto no carrinho
	 * ***************************************/
	if($funcao == 'add')
	{
		// remove a msg de erro
		$dados['msg'] = '';		
		
		// busca o produto
		$p = $this->carrinho_busca_produto();
		
		// adiciona o produto na sessao
		$itens[$p->carrinho->id] = array(
			'key' => $p->carrinho->id,
			'id' => $p->db->id,
			'img' => $p->db->imagem,
			'nome' => $p->carrinho->nome,
			'valorOriginal' => $p->db->valor,
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
		
		// reseta o cupom
		$dados['cupom'] = array('valor' => 0, 'code' => '', 'html' => '', 'tipo' => '', 'porcentagem' => 0);		
		
		// remove a msg de erro
		$dados['msg'] = '';
		
		if($cupom)
		{		
			$dados['cupom']['id'] = $cupom->id;
			$dados['cupom']['code'] = strtoupper($cupom->codigo);
			$dados['cupom']['valor'] = $cupom->valor;
			$dados['cupom']['tipo'] = $cupom->tipo;
		
			if($cupom->tipo == '$')
				$dados['cupom']['html'] = "- R$ " .number_format($cupom->valor, 2, ',', '.');

		}else
			$dados['msg'] = 'Código do cupom de desconto não encontrado.';
							
	}




	/* ***************************************
	 * Atualiza itens do carrinho
	 * ***************************************/
	if($funcao == 'update')
	{			
		// remove a msg de erro
		$dados['msg'] = '';
		
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
	 * Abre o cadastro
	 * ***************************************/
	if($funcao == 'cadastro')
	{			
		// remove a msg de erro
		$dados['msg'] = '';
		
		// verifica se o CEP foi preenchido
		if(!count($dados['cadastro']) && $dados['frete']['cep'] == '')
			$dados['msg'] = 'Informe o seu CEP.';
		else
		{
			// cria o link do carrinho com route
			$link = "index.php?option=com_edesktop&view=loja&layout=cadastro&Itemid={$this->itemid}";			
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
		$itens[$id]['valor'] = $item['valorOriginal'];
		$dados['frete']['peso'] = $dados['frete']['peso'] + ($item['peso'] * $item['quantidade']);
		$itens[$id]['total'] = $item['valorOriginal'] * $item['quantidade'];
		$dados['subtotal'] = $dados['subtotal'] + $itens[$id]['total'];
	}


	// total se desconto
	$dados['subtotalSemDesconto'] = $dados['subtotal'];

	
	if(count($itens))
	{
			
		// descontos do tipo %
		if($dados['cupom']['tipo'] == '%')
		{
			$dados['cupom']['porcentagem'] = ($dados['cupom']['valor'] / 100);
			$dados['cupom']['html'] = '- '.$dados['cupom']['valor'] .'%';
		}



		// descontos do tipo $
		if($dados['cupom']['tipo'] == '$')
		{
			$dados['cupom']['porcentagem'] = ($dados['cupom']['valor'] / $dados['subtotalSemDesconto']);
			$dados['cupom']['html'] = '- R$ '. $dados['cupom']['valor'];
		}


		if($dados['cupom']['valor'])
		{
			$dados['subtotal'] = 0;
			
			// Recalcula o valores dos itens
			foreach($itens as $id => $item)
			{
				$itens[$id]['valor'] = round($item['valorOriginal'] - ($item['valorOriginal'] * $dados['cupom']['porcentagem']), 2);
				$itens[$id]['total'] = $itens[$id]['valor'] * $item['quantidade'];
				$dados['subtotal'] = $dados['subtotal'] + $itens[$id]['total'];
			}
			
			// calcula o desconto
			$dados['descontoValor'] = $dados['subtotalSemDesconto'] - $dados['subtotal'];
		}
	}








	/* ***************************************
	 * FRETE - valor fixo no carrinho
	 * ***************************************/
	if($dados['frete']['tipo'] == 'fixo' && $dados['frete']['cep'])
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



	// atualiza as sessions
	$_SESSION[$sessao_itens] = $itens;
	$_SESSION[$sessao_dados] = $dados;



	// envia para o layout
	$this->assignRef('itens', $itens);
	$this->assignRef('dados', $dados);


	//print_r($dados);

?>