<?
jimport('edesktop.programas.base');
jimport('edesktop.programas.produtos');

class edLoja
{	
	var 
		$itemid = 7;
		
		
	public function __construct(){}
	
	
	public function getInstance()
	{
		$class = __CLASS__;		
		return new $class;
	}


	public function getConfig()
	{
		$config = array(
			'pagerMaxPerPage' => 12,
			'pagerOrders' => array(
				array('label' => 'Preço', 'sql' => 'valor ASC'),
				array('label' => 'Nome', 'sql' => 'nome ASC')
			)
		);

		return $config;
	}


	public function getProdutoHtml($p)
	{
		$html  = '';
		$html .= '<div class="produto">';

		$produto = "index.php?option=com_edesktop&view=loja&layout=produto&Itemid={$this->itemid}&id={$p->id}";
		$fabricanteALT = "";
				
		if($p->idfabricante)
		{
			$fabricante = "index.php?option=com_edesktop&view=loja&layout=fabricante&Itemid={$this->itemid}&id={$p->idfabricante}";
			$fabricanteALT = "- Produto {$p->Fabricante->nome}";
		}
		
		$html .= '<p class="img">';
		$html .= '	<a href="' .$produto. '">';
		$html .= '		<img src="' .$p->imagem->url. '" alt="' .$p->nome. ' ' .$fabricanteALT. '" width="130" height="150" />';
		$html .= '	</a>';
		$html .= '</p>';
		$html .= '<p class="nome">';
		$html .= '	<a href="' .$produto. '">' .$p->nome. '</a>';
		$html .= '</p>';
			
		if($p->idfabricante)
		{
			$html .= '<p class="fabricante">';
			$html .= '	<a href="' .$fabricante. '">' .$p->Fabricante->nome. '</a>';
			$html .= '</p>';
		}
			
		$html .= '<p class="valor">R$ ' .number_format($p->valor, 2, ',', '.'). '</p>';
		$html .= '</div>';
		
		return $html;		
	}


	public function getSelectOrdem($id)
	{
		
	}

}
?>