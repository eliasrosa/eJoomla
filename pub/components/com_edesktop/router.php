<?php
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
	
	// se o view da loja
	if($view == 'loja')
	{		
		// detlhes do produto
		if($layout == 'produto')
		{
			// importa a class categorias
			jimport('edesktop.programas.produtos.produtos');
			
			// inicia no obj
			$o = new edesktop_produtos_produtos();
			
			// busca dados
			$o = $o->busca_por_id($query['id']);
			
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
			jimport('edesktop.programas.produtos.categorias');
			
			// inicia no obj
			$o = new edesktop_produtos_categorias();
			
			// busca dados
			$o = $o->busca_por_id($query['id']);
			
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
			jimport('edesktop.programas.produtos.fabricantes');
			
			// inicia no obj
			$o = new edesktop_produtos_fabricantes();
			
			// busca dados
			$o = $o->busca_por_id($query['id']);
			
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
	

	return $vars;
}