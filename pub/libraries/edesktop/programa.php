<?
// no direct access
defined('_JEXEC') or die('Restricted access');

class programa
{
	
	private $__vars = array();
	
	private function __get($nome)
	{
		return $this->__vars[$nome];
	}

	private function __set($nome, $valor)
	{
		$this->__vars[$nome] = $valor;
	}	
	
	public function __construct()
	{
		// get token
		JRequest::checkToken('request') or jexit( 'eDeskop: Invalid Token' );

		// pega o token
		$this->token = EDESKTOP_TOKEN;

		// template do sistema
		$this->template = JRequest::getvar('template', 'edesktop');
		
		// pasta do programa
		$this->programa = JRequest::getvar('programa');
		
		// pagina do programa	
		$this->pagina = JRequest::getvar('pagina', 'index');	

		// carregar pagina
		$this->funcao = JRequest::getvar('funcao', 1);	
				
		// url base
		$this->url_base = EDESKTOP_URL;
		
		// url do programa
		$this->url_programa = EDESKTOP_URL .'/programas/'. $this->programa;
		
		// id do procedo
		$this->processID = JRequest::getvar('processID', false);
		
		// pasta do programa
		$this->pasta = EDESKTOP_PATH_PROGRAMAS .DS. $this->programa;
		
		// pasta das paginas
		$this->pasta_paginas = $this->pasta .DS. 'paginas';
		
		// carrega a class JCRUD
		require_once(EDESKTOP_PATH_INC .DS. 'jcrud.class.php');
		
		// carrega a class smarty
		require_once(EDESKTOP_PATH_INC .DS. 'smarty' .DS. 'Smarty.class.php');		
		
		// inicio o smarty
		$this->smarty = new Smarty();
		$this->smarty->compile_dir  = EDESKTOP_PATH_SMARTY_COPILE;
		$this->smarty->cache_dir    = EDESKTOP_PATH_SMARTY_CACHE;

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
		
		$script = '';
		
		if(!$this->funcao)
		{					
			// carrega os menus laterais
			jimport('edesktop.menu.lateral');
			
			// abre as configurações do programa
			$this->config = $this->get_config($this->programa);
			
			// verifica se existe o arquivo menus.php
			if(file_exists($this->pasta .DS. 'menus.php'))
				require_once($this->pasta .DS. 'menus.php');
				

			// inicia as variaveis de sessão do dialog/pagina
			$script = "<script type=\"text/javascript\">
					$(function(){
						var processID = '{$this->processID}';
						var \$dialog = $('#d' +processID);
						var \$main = \$dialog.parent();
						
						var url_js = '{$this->url_programa}/js';
						var url_base = '{$this->url_base}';
						var url_programa = '{$this->url_programa}';
							
						var pagina = '{$this->pagina}';
						var programa = '{$this->programa}';
						
						var formURL = function(pagina, programa){
							programa = (programa == undefined) ? '{$this->programa}' : programa;
							return '?{$this->token}=1&template={$this->template}&class=programa&programa=' +programa+ '&method=conteudo&pagina=' + pagina;
						};
			";
				
				
			// verifica se existe o arquivo js
			$js_file = $this->pasta_paginas .DS. $this->pagina.'.js';
			if(file_exists($js_file))
			{
				$handle = fopen($js_file, "r");
				$js_file = fread ($handle, filesize ($js_file));
				fclose ($handle);
				$script .= "// js_file\n\n". $js_file. "\n\n";
			}
							
			$script .= "});\n</script>\n\n";
				
		}
										
		// abre a página
		if($this->pagina == 'index')		
			$pagina = $this->pasta .DS. $this->pagina;
		else
			$pagina = $this->pasta_paginas .DS. $this->pagina;
		
		if(file_exists($pagina. '.html'))
		{
			if(file_exists($pagina .'.php'))
				require_once($pagina .'.php');
			
			echo $script;
			
			//
			echo $this->smarty->fetch($pagina. '.html');
		}	
			
		else
		{
			if($this->funcao)
				echo "{ 'msg' : 'Arquivo não encontrado! \"{$this->pagina}.html\"', 'tipo' : 'error' }";
			else
				echo "Arquivo não encontrado!<br><br>$pagina.html<br><br><br><br><a href=\"javascript:void(0);\" class=\"link\" rel=\"{}\">Voltar</a>";
		}

	}
	
	public function formURL($pagina, $programa = '')
	{
		$programa = ($programa == '') ? $this->programa : $programa;
		$url = "?{$this->token}=1&template={$this->template}&class=programa&programa={$programa}&method=conteudo&pagina={$pagina}";
		return $url;
	}
	
}



?>
