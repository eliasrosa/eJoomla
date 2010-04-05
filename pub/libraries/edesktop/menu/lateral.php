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

	public function add($alias, $titulo, $rel)
	{	
		// adiciona o menu
		$this->menus[$alias] = array( 'titulo' => $titulo, 'rel' => $rel );
	}
	
	public function show()
	{
		$pagina = JRequest::getvar('pagina');
		$active = JRequest::getvar('active_menu');
		
		$html = '<div class="menu_lateral"><h2>' .$this->titulo. '</h2>';
		
		foreach($this->menus as $alias => $menu)
		{
			$ativo = ( $pagina == $alias || $active == $alias) ? 'ativo' : '';
			$html .= '<a href="javascript:void(0);" class="link ' .$ativo. '" rel="' .$menu['rel']. '">' .$menu['titulo']. '</a>';
		}

		if($this->voltar)
			echo $this->criar_link_voltar();
		
		$html .= '</div>';
		
		echo $html;
		
	}
	
	private function criar_link_voltar()
	{
		return '<a href="javascript:void(0);" class="link voltar" rel="{}">Voltar</a>';
	}
}

?>
