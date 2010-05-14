<?php
	// carrega o mainframe
	global $mainframe;


	// checa o token dos envios de dados
	if(JRequest::get('post'))
		JRequest::checkToken() or die('Invalid Token');


	// Altera o titulo
	$_SESSION['eload']['title'] = "Cadastro - {sitename}";


	// adiciona o plugin de mascaras
	JHTML::script('jquery.meio.mask.min.js', 'media/com_edesktop/loja/js/');


	// adiciona o plugin de validaForm
	JHTML::script('jquery.validaform-1.0.13.js', 'media/com_edesktop/loja/js/');


	// adiciona o javascript do cadastro
	JHTML::script('cadastro.js', 'media/com_edesktop/loja/js/');


	// mensagem limpa
	$msg = '';
	
	
	// form limpo
	$formPagSeguro = '';
	
	// post limpo
	$post = array(
		'nome' => '',
		'email' => '',
		'telefone' => '',
		'anotacoes' => '',
		'numero' => '',
		'complemento' => ''
	);

	
	// nome das sessões
	$sessao_itens = 'loja.carrinho.itens';
	$sessao_dados = 'loja.carrinho.dados';


	// carrega a session
	if(isset($_SESSION[$sessao_itens]) || isset($_SESSION[$sessao_dados]))
	{
		$itens = $_SESSION[$sessao_itens];
		$dados = $_SESSION[$sessao_dados];

		if(JRequest::getvar('nome'))
		{
			
			// verifica o nome
			$post['nome'] = trim(JRequest::getvar('nome', ''));
			$sobrenome = explode(' ', $post['nome']);
			if(count($sobrenome) <=1)
				$msg = "Preencha o seu nome completo!";
				



			// verifica o e-mail
			$post['email'] = trim(JRequest::getvar('email', ''));
			if(!preg_match('/^([\w]+)(\.[\w]+)*@([\w\-]+)(\.[\w]{2,7})(\.[a-z]{2})?$/', $post['email']))
				$msg = "E-mail inválido!";
	
	
	
			// verifica o telefone
			$post['telefone'] = trim(JRequest::getvar('telefone', ''));
			$post['telefone'] = str_ireplace(array('(', ')', '-'), '', $post['telefone']);
			if(!preg_match('/^\d{2} \d{8}$/', $post['telefone']))
				$msg = "Telefone para contato inválido!";
	

			// verifica o numero
			$post['numero'] = trim(JRequest::getvar('numero', ''));
			if(!preg_match('/\S+/', $post['numero']))
				$msg = "Número inválido!";
				
				
			// carrega dados não obrigatórios
			$post['anotacoes'] = trim(JRequest::getvar('anotacoes', ''));
			$post['complemento'] = trim(JRequest::getvar('complemento', ''));
			
			
			// separa o telefone do ddd
			list($post['ddd'], $post['fone']) = explode(' ', $post['telefone']); 
			
			
			// remove o hifen do cep
			$post['cep'] = str_replace('-', '', $dados['frete']['cep']);
			
			// adiciona o end
			$post['end'] = str_replace('-', '', $dados['cadastro']['tipo_logradouro'] .' '. $dados['cadastro']['logradouro']);
			
						
				
				
			if($msg == '')
			{

				//  inicia o form
				$formPagSeguro = '<form class="pagseguro" method="post" action="https://pagseguro.uol.com.br/checkout/checkout.jhtml">
										<input type="hidden" name="email_cobranca" value="' .$this->config->get('pagSeguroEmailCobranca'). '">
										<input type="hidden" name="tipo" value="CP">
										<input type="hidden" name="encoding" value="utf-8" />
										<input type="hidden" name="moeda" value="BRL">';

				// dados
				$formPagSeguro .= '<input type="hidden" name="cliente_nome" value="' .$post["nome"]. '">';
				$formPagSeguro .= '<input type="hidden" name="cliente_cep" value="' .$post["cep"]. '">';
				$formPagSeguro .= '<input type="hidden" name="cliente_end" value="' .$post["end"]. '">';
				$formPagSeguro .= '<input type="hidden" name="cliente_num" value="' .$post["numero"]. '">';
				$formPagSeguro .= '<input type="hidden" name="cliente_compl" value="' .$post["complemento"]. '">';
				$formPagSeguro .= '<input type="hidden" name="cliente_bairro" value="' .$dados['cadastro']['bairro']. '">';
				$formPagSeguro .= '<input type="hidden" name="cliente_cidade" value="' .$dados['cadastro']['cidade']. '">';
				$formPagSeguro .= '<input type="hidden" name="cliente_uf" value="' .$dados['cadastro']['uf']. '">';
				$formPagSeguro .= '<input type="hidden" name="cliente_pais" value="BRA">';
				$formPagSeguro .= '<input type="hidden" name="cliente_ddd" value="' .$post["ddd"]. '">';
				$formPagSeguro .= '<input type="hidden" name="cliente_tel" value="' .$post["fone"]. '">';
				$formPagSeguro .= '<input type="hidden" name="cliente_email" value="' .$post["email"]. '">';
															
				
				$porcentDesconto = ($dados['cupom']['valor'] / 100);
				
				// carrega os produtos
				$x = 1;					
				foreach($itens as $i)
				{										
					$formPagSeguro .= '<input type="hidden" name="item_id_' .$x. '" value="' .$i["id"]. '">';
					$formPagSeguro .= '<input type="hidden" name="item_descr_' .$x. '" value="' .$i["nome"]. '">';
					$formPagSeguro .= '<input type="hidden" name="item_quant_' .$x. '" value="' .$i["quantidade"]. '">';
					$formPagSeguro .= '<input type="hidden" name="item_valor_' .$x. '" value="' .number_format($i["valor"], '2', '', ''). '">';
					$formPagSeguro .= '<input type="hidden" name="item_frete_' .$x. '" value="0">';
					$formPagSeguro .= '<input type="hidden" name="item_peso_' .$x. '" value="0">';
					$x++;
				}


				// frete
				if($dados['frete']['tipo'] == 'fixo')
				{
					$formPagSeguro .= '<input type="hidden" name="tipo_frete" value="EN">';
					$formPagSeguro .= '<input type="hidden" name="item_id_' .$x. '" value="frete">';
					$formPagSeguro .= '<input type="hidden" name="item_descr_' .$x. '" value="Frete Encomenda econômica (PAC)">';
					$formPagSeguro .= '<input type="hidden" name="item_quant_' .$x. '" value="1">';
					$formPagSeguro .= '<input type="hidden" name="item_valor_' .$x. '" value="' .$dados["frete"]["valor"]. '">';
					$formPagSeguro .= '<input type="hidden" name="item_frete_' .$x. '" value="0">';
					$formPagSeguro .= '<input type="hidden" name="item_peso_' .$x. '" value="0">';
				}



				$formPagSeguro .= '</form>';
				$formPagSeguro .= '<script>$(\'#loja-cadastro form.pagseguro\').submit();</script>';
									
			}
			
							

		}


		// envia para o layout
		$this->assignRef('msg', $msg);
		$this->assignRef('post', $post);
		$this->assignRef('dados', $dados);
		$this->assignRef('formPagSeguro', $formPagSeguro);

	}
	else
	{
		// cria o link do carrinho com route
		$link = JRoute::_("index.php?option=com_edesktop&view=loja&layout=carrinho&Itemid={$this->itemid}");		
		
		// redireciona para o carrinho
		$mainframe->redirect($link);
	}	


	//print_r($dados);

?>
