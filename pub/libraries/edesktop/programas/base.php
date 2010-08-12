<?
jimport('edesktop.doctrine.conexao');

jimport('edesktop.util');

class eDesktopBasePrograma
{
	var
		$dqls,
		$query,
		$pager = false,
		$pagerNome = '',
		$pagerRanger = false,
		$pagerLayout = false,
		$pagerOrders = array(),
		$urlTemplate = '',
		$pagerMaxPerPage = 10,
		$pagerGetPage = 1,
		$pagerGetPageVar = 'pag',
		$pagerLayoutTemplate = '<a class="pag" href="{%url}">{%page}</a>',
		$pagerLayoutTemplateSelect = '<a href="{%url}" class="pag select active">{%page}</a>',
		$pagerRangerOptions = array('chunk' => 7);


	public function __construct()
	{
		$this->dqls = new stdClass();
	}


	public function getQuery()
	{
		return $this->query;
	}



	public function fetchOne($params = array(), $hydrationMode = null)
	{
		return $this->query->fetchOne($params, $hydrationMode);
	}


	public function execute($params = array(), $hydrationMode = null)
	{
		return $this->query->execute($params, $hydrationMode);
	}


	public function setConfig($config)
	{
		if(is_array($config))
			foreach($config as $var=>$value)
				$this->$var = $value;
		
		return $this;
	}

	
	public function getImgStatus($status)
	{ 
		if($status)
			return '<img src="'.JURI::base(1).'/media/com_edesktop/imagens/ok.png" />';
		else
			return '<img src="'.JURI::base(1).'/media/com_edesktop/imagens/x.png" />';
	}	


	public function getUrl404()
	{ 
		return JURI::base(1).'/media/com_edesktop/imagens/404.jpg';
	}	


	/* Adiciona condição no dql
	 * 
	 * Exemplo:
	 *    $dados = edProdutos::getInstance()
	 * 					->busca_todos_produtos()
	 * 					->andWhere('p.status >= ?', 1)
	 * 					->createPager();
	 * 
	 **/
	public function andWhere($sql1, $sql2 = null)
	{
		if(is_null($sql2))
			$dql = $this->query->andWhere($sql1);
		else
			$dql = $this->query->andWhere($sql1, $sql2);
			
		$this->query = $dql;
		
		return $this;
	}


	/* CRIA PAGINAÇÃO DO DQL
	 * 
	 * Exemplo:
	 *    $dados = edProdutos::getInstance()
	 * 					->busca_todos_produtos()
	 * 					->createPager();
	 * 
	 *    foreach($dados->pagerLayout->execute() as $p){...}
	 *   
	 *    echo $dados->pagerLayout->display();
	 * 
	 **/
	public function createPager($dql = null, $template = 'site')
	{
		$this->pagerGetPageVar = $this->pagerNome.$this->pagerGetPageVar;
		$this->pagerGetPage = JRequest::getInt($this->pagerGetPageVar, 1);
		
		$this->_configPagerOrder();
		$this->_configUrl();
		
		$this->query = is_null($dql) ? $this->query : $dql;
		
		$this->pager = new Doctrine_Pager($this->query, $this->pagerGetPage, $this->pagerMaxPerPage);
		$this->pagerRanger = new Doctrine_Pager_Range_Sliding($this->pagerRangerOptions);

		if($template == 'site')
		{
			$this->pagerLayout = new Doctrine_Pager_Layout($this->pager, $this->pagerRanger, $this->urlTemplate);
			$this->pagerLayout->setTemplate($this->pagerLayoutTemplate);
			$this->pagerLayout->setSelectedTemplate($this->pagerLayoutTemplateSelect);
		}
		
		if($template == 'edesktop')
		{
			
			$rel = "'query': '{$this->pagerGetPageVar}={%page}&'";
			
			$this->pagerLayoutTemplate = '<a class="link pag" href="{%url}" rel="'.$rel.'">{%page}</a>';
			$this->pagerLayoutTemplateSelect = '<span class="pag active select">{%page}</span>';
			
			$this->pagerLayout = new Doctrine_Pager_Layout($this->pager, $this->pagerRanger, $this->urlTemplate);
			$this->pagerLayout->setTemplate($this->pagerLayoutTemplate);
			$this->pagerLayout->setSelectedTemplate($this->pagerLayoutTemplateSelect);
		}
		
		return $this;
	}
			
		
	private function _configPagerOrder()
	{
		$orders = $this->pagerOrders;
		
		if(count($orders))
		{
			$this->pagerGetOrderVar = $this->pagerNome.'ordem';
			$this->pagerGetOrder = JRequest::getInt($this->pagerGetOrderVar, 0);
			
			if(isset($orders[$this->pagerGetOrder]['sql']))
			{
				$order = $orders[$this->pagerGetOrder]['sql'];
				$this->query = $this->query->orderBy($order);
			}
		}	
	}

	public function getPagerOrder()
	{
		$u =& JURI::getInstance();
		$orders = $this->pagerOrders;
		
		if(count($orders))
		{
			$this->pagerGetOrderVar = $this->pagerNome.'ordem';
			$this->pagerGetOrder = JRequest::getInt($this->pagerGetOrderVar, 0);

			$html = '';
			$options = '';
			foreach($orders as $k=>$ordem)
			{
				$u->setVar($this->pagerGetPageVar, 1);
				$u->setVar($this->pagerGetOrderVar, $k);
				$selected = ($k == $this->pagerGetOrder) ? ' selected="selected"' : '';
				$options .= sprintf('<option value="%s" %s>%s</option> ', JRoute::_($u->toString()), $selected, $ordem['label']);
			}

			$js = sprintf('<script type="text/javascript">$(function(){ $(\'select#%s\').change(function(){window.location = $(this).val();});});</script>', $this->pagerGetOrderVar);
			$html = sprintf('<select name="%s" id="%s">%s</select>%s', $this->pagerGetOrderVar, $this->pagerGetOrderVar, $options, $js);		
							
			return $html;
		}	
	}


	private function _configUrl()
	{
		$u =& JURI::getInstance();
		$queryString = array_merge($u->getQuery(1), array($this->pagerGetPageVar => '{%page_number}'));
		$u->setQuery($queryString);
		$this->urlTemplate = urldecode($u->toString());
		$u->setVar($this->pagerGetPageVar, $this->pagerGetPage);
	}
}
?>