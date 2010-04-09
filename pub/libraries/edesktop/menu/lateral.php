<?

class menu_lateral
{
	private $titulo, $voltar;
	private $menus = array();
	
	public function __construct($titulo, $voltar = false)
	{
		// altera a var título
		$this->titulo = $titulo;
		
		// altera a var  voltar
		$this->voltar = $voltar;
	}

	public function add($titulo, $params)
	{	
		if(is_array($params))
		{	
			$alias = $params['pagina'];
		}

		if(is_string($params))
		{	
			$alias  = $params;
			$params = array( 'pagina' => $params );
		}
		
		if(isset($params['query']))
		{
			parse_str($params['query'], $query);
			$alias = $alias .'.'. $query['ativarMenu'];
		}
		
		// convert params para json
		$rel = str_replace('"', '\'', json_encode($params));
		
		// adiciona o menu
		$this->menus[$alias] = array( 'titulo' => $titulo, 'rel' => $rel );
	}
	
	public function show()
	{
		$pagina = JRequest::getvar('pagina');
		$ativarMenu = JRequest::getvar('ativarMenu');

		$html = '<div class="menu_lateral"><h2>' .$this->titulo. '</h2>';
		
		foreach($this->menus as $alias => $menu)
		{
			$class = ($alias == $pagina || $alias == "$pagina.$ativarMenu") ? 'ativo' : '';			
			$html .= '<a href="javascript:void(0);" class="link ' .$class. '" rel="' .$menu['rel']. '"><span class="ui-icon ui-icon-bullet"></span>' .$menu['titulo']. '</a>';
		}
		
		$html .= '</div>';
		
		echo $html;
		
		if($this->voltar)
			echo $this->criar_link_voltar();
				
	}
	
	private function criar_link_voltar()
	{
		return '<a href="javascript:void(0);" class="link voltar" rel="{}">Voltar ao inicio</a>';
	}
}

?>
