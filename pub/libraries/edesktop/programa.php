<?
class programa
{
	
	public $url_base;
	public $url_programa;
	public $processID;
	public $config;
		
	
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
	
	
	public function conteudo()
	{
		// pasta do programa
		$programa = JRequest::getvar('programa');
		
		// pagina do programa	
		$pagina = JRequest::getvar('pagina');	
		
		// corrige a barras
		$pagina = str_ireplace('.', DS, $pagina);
		
		// abre as configurações do programa
		$this->config = $this->get_config($programa);
		$this->url_base = EDESKTOP_URL ;
		$this->url_programa = EDESKTOP_URL .'/programas/'. $programa ;
		$this->processID = JRequest::getvar('processID', 0);
		
		// abre a página
		$file = EDESKTOP_PATH_PROGRAMAS .DS. $programa .DS. $pagina .'.php';
		
		if(file_exists($file))
			require_once($file);
		else
			echo "Arquivo não encontrado!<br><br>$file<br><br><br><br><a href=\"javascript:void(0);\" class=\"link\" rel=\"{}\">Voltar</a>";
		
	}
}



?>
