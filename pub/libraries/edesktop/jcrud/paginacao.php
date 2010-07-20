<?php
class paginacao
{
	var $por_pagina = 20;
	var $url_base = null;
	var $get_var = '';
	var $pagina_atual = 0;
	var $row_fim = 0;
	var $row_inicio = 0;
	var $total_registros = 0;
	var $total_paginas = 0;
	var $orders = array();
	var $order_atual = '';
	var $html = array();
	
	// 
	function __construct()
	{
		$this->get_var_pagina = $this->get_var.'pag';
		$this->get_var_order = $this->get_var.'order';
	}
	
	// inicia o cálculo de paginação 
	function init($total_registros)
	{
		$this->__construct();
		
		// pega a pagina atual
		$this->pagina_atual = JRequest::getInt($this->get_var_pagina, 1);

		// total de regitros
		$this->total_registros = (int) $total_registros;
		
		if(!$this->total_registros && $this->pagina_atual > 0)
			return array();
		
		// calcula a linha do registro de inicio
		$this->row_fim = ($this->por_pagina * $this->pagina_atual) - 1;
		$this->row_inicio = $this->por_pagina * ($this->pagina_atual - 1);

		// calcula o total de páginas
		$this->total_paginas = ceil($this->total_registros / $this->por_pagina);

		// cria os html das paginas
		$this->cria_html();
				
		return;
	}


	//
	function cria_html()
	{
		// adiciona a biblioteca juri
		jimport('joomla.environment.uri');

		// verifica se a urlbase foi adicionada
		if(!is_null($this->url_base))
			$u =& JURI::getInstance($this->url_base);
		
		// caso contrário usa a urel atual
		else
			$u =& JURI::getInstance();
		
		$links = '';
		$paginas_adm_select = '';
		$select = '';
			
		// loop nas páginas
		for ($i = 1; $i <= $this->total_paginas; $i++)
		{
			// adiciona a var na url
			$u->setVar($this->get_var_pagina, $i);
					
			// retorna o html tag a
			$class = $i == $this->pagina_atual ? ' class="atual"' : '';
			$links .= sprintf('<a href="%s"%s>%d</a> ', JRoute::_($u->toString()), $class, $i);
			
			// retorna o html select
			$selected = $i == $this->pagina_atual ? ' selected="selected"' : '';
			
			// cria o select para o site
			$select .= sprintf('<option value="%s" %s>Página %d</option> ', JRoute::_($u->toString()), $selected, $i);
			
			// cria o select para o adm
			$paginas_adm_select .= sprintf('<option value="%s" %s>Página %d</option> ', $i, $selected, $i);
		}		
		
		// paginas para o adm
		$query = JRequest::get('post');
		unset($query[JUtility::getToken()], $query['funcao'], $query['method'], $query['class'], $query['pagina'], $query['programa'], $query['template'], $query['processID']);
		$u->setQuery($query);
		$u->setVar($this->get_var_pagina, '');
		$js = sprintf('<script type="text/javascript">$(function(){ $(\'select#%s\').change(function(){ eDesktop.dialog.load({programa: "%s", processID: "%s", pagina: "%s", query: "%s"+ $(this).val() }); });});</script>', $this->get_var_pagina, JRequest::getvar('programa'), JRequest::getvar('processID'), JRequest::getvar('pagina'), $u->getQuery());
		$paginas_adm_select = sprintf('<select name="%s" id="%s">%s</select>%s ', $this->get_var_pagina, $this->get_var_pagina, $paginas_adm_select, $js);		
		$this->html['paginas.adm.select'] = $paginas_adm_select;
		
		
		// páginas para o site
		$js = sprintf('<script type="text/javascript">$(function(){ $(\'select#%s\').change(function(){window.location = $(this).val();});});</script>', $this->get_var_pagina);
		$select = sprintf('<select name="%s" id="%s">%s</select>%s', $this->get_var_pagina, $this->get_var_pagina, $select, $js);		
		$this->html['paginas.links'] = $links;
		$this->html['paginas.select'] = $select;


		// ordem para site
		$order = '';
		$this->order_atual = JRequest::getVar($this->get_var_order);
		
		if(count($this->orders))
		{

			foreach($this->orders as $k=>$v)
			{
				$u->setVar($this->get_var_pagina, 1);
				$u->setVar($this->get_var_order, $k);
				$selected = $k == $this->order_atual ? ' selected="selected"' : '';
				$order .= sprintf('<option value="%s" %s>%s</option> ', JRoute::_($u->toString()), $selected, $v['label']);
			}

			$js = sprintf('<script type="text/javascript">$(function(){ $(\'select#%s\').change(function(){window.location = $(this).val();});});</script>', $this->get_var_order);
			$order = sprintf('<select name="%s" id="%s">%s</select>%s', $this->get_var_order, $this->get_var_order, $order, $js);		
			
			//
			$this->html['order.select'] = $order;
			
		}
		
		foreach($this->html as $k=>$v)
		{
			$key = str_replace('.', '_', $k);
			$this->html[$key] = $v;
		}		
	}


	function get_order()
	{
		// busca o get order
		$order = JRequest::getInt($this->get_var_order, 0);
		
		$sql = 'ORDER BY ';
		
		if(isset($this->orders[$order]['sql']))
			return $sql.$this->orders[$order]['sql'];
		
		else
			return $sql.$this->orders[0]['sql'];
		
	}

}

?>
