<?php
jimport('edesktop.util');

function edesktopBuildRoute( &$query )
{
	jimport( 'joomla.filter.output' );

	$segments = array();
	$itemid = JRequest::getvar('Itemid');
	$menu =& JSite::getMenu();
	$item =& $menu->getItem($itemid);
	$params = $menu->getParams($item->id);
	
	
	$itemid = ($params->get('Itemid')) ? $params->get('Itemid') : $itemid;
	
	// carrega vars
	//$view = $item->query['view'];
	//$layout = isset($query['layout']) ? $query['layout'] : $item->query['layout'];


	// verifica se a var query existe
	$view = '';
	if (isset($query['view'])) {
		$view = $query['view'];	
		unset($query['view']);
	}
	
	// verifica se a var query existe
	if (isset($query['layout'])){
		$layout = $segments[] = $query['layout'];
		unset($query['layout']);
	}

	// se o view da mailing
	if($view == 'mailing')
	{		
		if($layout == 'exibir')
		{
			// importa a class categorias
			jimport('edesktop.programas.mailing');
			
			$id = util::int($query['id'], 0);
			
			$m = new edMailing();
			$email = $m->busca_email_ativo_id($id);
			
			if($email)
			{
				$assunto = JFilterOutput::stringURLSafe($email->assunto);
				
				$segments[] = $id;
				$segments[] = $assunto;
	
				// remove o id
				unset($query['id']);
			}

		}	
	}

	
	// se o view da loja
	if($view == 'loja')
	{		
		// detlhes do produto
		if($layout == 'produto')
		{
			// importa a class categorias
			jimport('edesktop.programas.produtos');
			
			// busca dados
			$o = edProdutos::getInstance()
					->busca_produto_ativo_por_id($query['id'])
					->fetchOne();			

			// nome da alias
			$nome = ($o->alias == '') ? $o->nome : $o->alias;
			
			// convert nome
			$nome = JFilterOutput::stringURLSafe($nome);
						
			// adiciona os segmentos
			$segments[] = $o->id;
			$segments[] = $nome;
			
			// remove o id
			unset($query['id']);
		
		}

		// lista de produtos por categoria
		if($layout == 'categoria')
		{
			// importa a class categorias
			jimport('edesktop.programas.produtos');
			
			// busca dados
			$o = edProdutos::getInstance()
					->busca_categoria_ativa_por_id($query['id'])
					->fetchOne();			
			
			// nome da alias
			$nome = ($o->alias == '') ? $o->nome : $o->alias;
			
			// convert nome
			$nome = JFilterOutput::stringURLSafe($nome);
						
			// adiciona os segmentos
			$segments[] = $o->id;
			$segments[] = $nome;
			
			// remove o id
			unset($query['id']);
		
		}	

		// lista de produtos por fabricante
		if($layout == 'fabricante')
		{
			// importa a class categorias
			jimport('edesktop.programas.produtos');
			
			// busca dados
			$o = edProdutos::getInstance()
					->busca_fabricante_ativo_por_id($query['id'])
					->fetchOne();			
			
			// nome da alias
			$nome = ($o->alias == '') ? $o->nome : $o->alias;
			
			// convert nome
			$nome = JFilterOutput::stringURLSafe($nome);
						
			// adiciona os segmentos
			$segments[] = $o->id;
			$segments[] = $nome;
			
			// remove o id
			unset($query['id']);
		}				
	}
	



	return $segments;
}


function edesktopParseRoute( $segments )
{
	$menu =& JSite::getMenu();
	$item =& $menu->getActive();
	$params = $menu->getParams($item->id);
	
	// carrega vars
	$vars['view'] = $item->query['view'];
	$vars['layout'] = $segments[0];
	$vars['Itemid'] = $item->id;
	
	// se o view da loja
	if($vars['view'] == 'loja')
	{
		// produtos
		if($vars['layout'] == 'produto' || $vars['layout'] == 'categoria' || $vars['layout'] == 'fabricante')
		{
			$layout = $segments[0];
			$id = $segments[1];
			$alias = $segments[2];
			
			// carrega o id
			$vars['id'] = $id;
		}		
	}

	// se o view da mailing
	if($vars['view'] == 'mailing')
	{		
		if($vars['layout'] == 'exibir')
		{			
			$vars['layout'] = $segments[0];
			$vars['id'] = $segments[1];
		}	
	}

	return $vars;
}