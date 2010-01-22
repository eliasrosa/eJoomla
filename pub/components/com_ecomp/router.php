<?
jimport( 'joomla.filter.output' );

require_once(JPATH_ROOT.DS.'media'.DS.'com_ecomp'.DS.'comum.php');
require_once(ECOMP_PATH_CLASS.DS.'ebasic.util.php');
require_once(ECOMP_PATH_CLASS.DS.'ebasic.jcrud.php');


function EcompBuildRoute(&$query)
{
	$vars         =  $query;
	$menu         =& JSite::getMenu();
	$item         =& $menu->getItem($vars['Itemid']);
	$params       =  $menu->getParams($vars['Itemid']);
	$idcomponente =  $params->get('idcomponente');
	$idcadastro   =  isset($vars['id']) ? $vars['id'] : $params->get('idcadastro');
	$segments     =  array();
	$values       =  array();


	// abre a tabela de regras de rotas
	$r = new JCRUD(ECOMP_TABLE_ROUTERS_RULES);
	$r = $r->busca("WHERE itemid = '{$item->id}' AND published = '1' AND trashed != '1' ORDER BY ordering ASC");
	
	foreach($r as $rules)
	{
		if($rules->type == '1')
		{	
			// nome da tebela do componente
			$tabela = eHelper::componente_tabela_nome($idcomponente);

			$c = new JCRUD($tabela);
			$c = $c->busca_por_id($idcadastro);
				
			if($c)
			{
				
				$campo = $rules->alias1;
				if($campo == '' || JFilterOutput::stringURLSafe($c->$campo) == '')
					$campo = $rules->alias2;
					
				$segments[] = JFilterOutput::stringURLSafe($c->$campo);
				$values[$rules->get_var] = isset($vars[$rules->get_var]) ? $vars[$rules->get_var] : $rules->get_value;
			}
			
			
		}

		if($rules->type == '2')
		{	
			$segments[]  = JFilterOutput::stringURLSafe($rules->alias1); 
			$values[$rules->get_var] = isset($vars[$rules->get_var]) ? $vars[$rules->get_var] : $rules->get_value;
		}

		if($rules->type == '3')
		{	
			$s = isset($vars[$rules->get_var]) ? $vars[$rules->get_var] : $rules->get_value;
			$segments[]  = JFilterOutput::stringURLSafe($s); 
			$values[$rules->get_var] = $s;
		}
		
		// exclui a var caso exista
		if(isset($query[$rules->get_var]))
			unset($query[$rules->get_var]);		
		
	}
	
	// exclui a var view 'padrao'
	if(isset($vars['view']) && $vars['view'] == 'padrao')
		unset( $query['view'] );
		
	
	////////////////////////////////////////////
	////  CACHE
	///////////////////////////////////////////
	
	if(count($segments))
	{
		$url = join('/', $segments);
		$params = http_build_query($values, '', '&');
		
		$dados = array(
			'id' => 0,
			'itemid' => $item->id,
			'url' => $url,
			'params' => $params
		);
			
		// adicionao a rota na tabela cache
		$c = new JCRUD(ECOMP_TABLE_ROUTERS_CACHE, $dados);
		$cc = $c->busca("WHERE itemid = '{$item->id}' AND url = '{$url}'");
									
		if(count($cc))
		{	
			$c->id = $cc[0]->id;
			$c->update();
		}
		else
			$c->insert();
	}

	return $segments;
}


function EcompParseRoute( $segments )
{
	$vars         =  array();
	$menu         =& JSite::getMenu();
	$item         =& $menu->getActive();
	
	// remove o : da array
	foreach($segments as $k=>$v)
		$segments[$k] = str_replace(':', '-', $v);
		
	// cria a url
	$url = join('/', $segments);

	// abre a tabela de cache
	$r = new JCRUD(ECOMP_TABLE_ROUTERS_CACHE);
	$r = $r->busca("WHERE url = '{$url}' LIMIT 0,1");

	if(count($r))
	{
		// carega vars padrao
		$vars = $item->query;
		
		// carrega o itemid
		$vars['Itemid'] = $item->id;
		
		// trasnforma a string em array
		parse_str($r[0]->params, $params);
		
		// merge com as vars
		$vars = array_merge($vars, $params);
	}	
		
	return $vars;
}


?>
