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
	$conf         =& JFactory::getConfig();

	// abre a tabela de regras de rotas
	$r = new JCRUD(ECOMP_TABLE_ROUTERS_RULES);
	$r = $r->busca("WHERE itemid = '{$item->id}' AND published = '1' AND trashed != '1' ORDER BY ordering ASC");
	
	foreach($r as $rules)
	{
		if($rules->type == '1')
		{	
			// nome da tebela do componente
			$idcomp = $rules->idcomponente > 0 ? $rules->idcomponente : $idcomponente;
			$tabela = eHelper::componente_tabela_nome($idcomp);

			$c = new JCRUD($tabela);
			$x = isset($vars[$rules->get_var]) ? $vars[$rules->get_var] : '0';
			$c = $c->busca_por_id($x);
				
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


		// categoria
		if($rules->type == '4')
		{	
			$c = new JCRUD(ECOMP_TABLE_CATEGORIAS);
			$y = (int) $rules->get_value;
			$x = isset($vars[$rules->get_var]) ? $vars[$rules->get_var] : $y;
			$c = $c->busca_por_id($x);
			
				
			if($c)
			{
				$campo = 'alias';
				if(JFilterOutput::stringURLSafe($c->$campo) == '')
					$campo = 'nome';
					
				$segments[] = JFilterOutput::stringURLSafe($c->$campo);
				$values[$rules->get_var] = isset($vars[$rules->get_var]) ? $vars[$rules->get_var] : $rules->get_value;
			}

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
		// verifica se o sef_suffix esta ativado
		$sef_suffix  = $conf->getValue('config.sef_suffix') ? '.html' : '';

		$url = join('/', $segments).$sef_suffix;
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
	$vars =  array();
	$menu =& JSite::getMenu();
	$item =& $menu->getActive();
	$conf =& JFactory::getConfig();
		
	// remove o : da array
	foreach($segments as $k=>$v)
		$segments[$k] = str_replace(':', '-', $v);
		
	// cria a url
	$url = join('/', $segments);
	
	// verifica se o sef_suffix esta ativado
	$sef_suffix = $conf->getValue('config.sef_suffix') ? true : false;
	if($sef_suffix)
	{
		$u =& JURI::getInstance();
		$ext = JFile::getExt($u->getPath());
		
		if($ext == 'html')
			$url = $url.'.html';
	}	
	
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
