<?php
defined('_JEXEC') or die( "Acesso Restrito" );

class modEdesktopLojaCategoriasHelper
{
	var 
		$base = array();
		
		
	public function __construct()
	{
		$session = 'eDesktop.loja.categorias';
		
		if(!isset($_SESSION[$session]))
		{
			$this->getDados();
			$html = $this->montaMenu(0);
			
			$_SESSION[$session] = array(
				'expira' => '',
				'html' => $html
			);
		}
		
		echo $_SESSION[$session]['html'];
	}
	
	
	public function getDados()
	{
		
		$q = edProdutos::getInstance()
				->busca_todas_categorias_ativas()
				->query
				->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);


		foreach($q->execute() as $i)
			$this->base[$i['idpai']][] = $i;
			
		$this->itemid = edLoja::getInstance()->itemid;
	}


	public function montaMenu($idpai = 0)
	{
		$categorias = isset($this->base[$idpai]) ? $this->base[$idpai] : array();
		
		$m = '';		
		if(count($categorias))
		{
			$class = ($idpai == 0) ? ' class="menu"' : '';
			$m .= "<ul{$class}>";

			
			foreach($categorias as $c)
			{
				$s = $this->montaMenu($c['id']);
				$class = ($s == '') ? '' : ' class="pai"';
				$href = "index.php?option=com_edesktop&view=loja&layout=categoria&Itemid={$this->itemid}&id={$c['id']}";

				$m .= "<li{$class}><a href=\"{$href}\">{$c['nome']}</a>{$s}</li>";
			}
						
			$m .= "</ul>";
		}
			
		return $m;
	}
}

?>

