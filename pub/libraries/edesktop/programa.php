<?
class programa
{
	
	public $e_url_base;
	public $e_url_programa;
		
	
	public function __construct()
	{

	}

	public function get_config($programa, $json = false)
	{
		$file = EDESKTOP_PATH_PROGRAMAS .DS. $programa .DS. 'configuracoes.php';
		
		if(file_exists($file))
		{
			require_once($file);
			
			if($json)
				echo json_encode($configuracoes);
			else
				return $configuracoes;
		}
	}
	
	public function get_list()
	{
		jimport('joomla.filesystem.folder');
		
		$dados = array();
		$programas = JFolder::folders(EDESKTOP_PATH_PROGRAMAS);
		
		foreach($programas as $p)
		{
			$a = array('programa' => $p);
			$d = $this->get_config($p); 
			
			$dados[] = array_merge($a, $d);
		}		
		
		echo json_encode($dados);
		
	}		
	
	
	public function dialog()
	{
		// pasta do programa
		$programa = JRequest::getvar('programa');	
		
		// abre as configurações do programa
		$config = $this->get_config($programa);
	
		// carrega a pagina solicitada
		$pagina = JRequest::getvar('pagina', 'undefined');
		
		// verifica se a página foi solicitada
		if($pagina == 'undefined')
			$pagina = $config['default'];
							
		// carrega as variaveis	
		$this->e_url_base = EDESKTOP_URL ;
		$this->e_url_programa = EDESKTOP_URL .'/programas/'. $programa ;
		
		// abre a página
		$file = EDESKTOP_PATH_PROGRAMAS .DS. $programa .DS. $pagina .DS. 'index.php' ;
		require_once($file);
		
	}	
	
}



?>
