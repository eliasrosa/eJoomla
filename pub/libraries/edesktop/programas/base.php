<?
jimport('edesktop.doctrine.conexao');

jimport('edesktop.util');

class eDesktoBase
{
	var
		$query,
		$isAdmin = false,
		$pager = false,
		$pagerNome = '',
		$pagerRanger = false,
		$pagerLayout = false,
		$pagerOrders = array(),
		$urlTemplate = '',
		$pagerMaxPerPage = 10,
		$pagerGetPage = 1,
		$pagerGetPageVar = 'pag',
		$pagerLayoutTemplate = '<a href="{%url}">{%page}</a>',
		$pagerLayoutTemplateSelect = '<a href="{%url}" class="select active">{%page}</a>',
		$pagerRangerOptions = array('chunk' => 7);
			


	public function createPager()
	{
		$this->pagerGetPageVar = $this->pagerNome.$this->pagerGetPageVar;
		$this->pagerGetPage = JRequest::getInt($this->pagerGetPageVar, 1);
		
		$this->_configPagerOrder();
		$this->_configUrl();
		
		$this->pager = new Doctrine_Pager($this->query, $this->pagerGetPage, $this->pagerMaxPerPage);
		$this->pagerRanger = new Doctrine_Pager_Range_Sliding($this->pagerRangerOptions);

		$this->pagerLayout = new Doctrine_Pager_Layout($this->pager, $this->pagerRanger, $this->urlTemplate);
		$this->pagerLayout->setTemplate($this->pagerLayoutTemplate);
		$this->pagerLayout->setSelectedTemplate($this->pagerLayoutTemplateSelect);
		
		return $this->pagerLayout;
	}
		
	
		
	private function _configPagerOrder()
	{
		$orders = $this->pagerOrders;
		
		if(count($orders))
		{
			$pagerGetOrderVar = $this->pagerNome.'ordem';
			$pagerGetOrder = JRequest::getInt($pagerGetOrderVar, 0);
			
			if(isset($orders[$pagerGetOrder]['sql']))
			{
				$order = $orders[$pagerGetOrder]['sql'];
				$this->query = $this->query->orderBy($order);
			}
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