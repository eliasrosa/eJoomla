<?
// carrega o jcrud
jimport('edesktop.jcrud');

// inicia a class
class edBanners
{

	/* tabelas
	 ***************************************************/
	private $tabelas = array(
		'banners' => 'jos_edesktop_banners',
		'slides' => 'jos_edesktop_banners_slides'
	);


	/* default values
	 ***************************************************/
	private $default_values = array(
		
		// tabela banners
		'banners' => array(
			'id' => 0,
			'nome' => '',
			'largura' => '',
			'altura' => '',
			'modelo' => 'js.cycle.mod01',
			'params' => ''
		),
		
		// tabela slides
		'slides' => array(
			'id' => 0,
			'idbanner' => 0,
			'nome' => '',
			'arquivo' => '',
			'url' => '',
			'target' => '',
			'order' => '1',
			'status' => 1,
		)
	);
	

	/* caminhos das pastas
	 ***************************************************/
	public $url = array();
	public $path = array();


	/* inicia a class
	 ***************************************************/
	function __construct()
	{
		$this->url['media'] = JURI::base()."media/com_edesktop/banners/";
		$this->path['media'] = JPATH_BASE .DS. 'media' .DS. 'com_edesktop' .DS. 'banners';
		
		$this->url['uploads'] = $this->url['media'] .'uploads/';
		$this->path['uploads'] = $this->path['media'] .DS. 'uploads';

		$this->url['js'] = $this->url['media'] .'js/';
		$this->path['js'] = $this->path['media'] .DS. 'js';

		$this->url['modelos'] = $this->url['media'] .'modelos/';
		$this->path['modelos'] = $this->path['media'] .DS. 'modelos';				
	}
	
	
	/* carrega o DB da tabela selecionada
	 ***************************************************/
	function db($tabela, $dados = array())
	{
		// Abre a tabela
		return new JCRUD($this->tabelas[$tabela], $dados);
	}
	
	
	/* busca banner pelo id
	 ***************************************************/
	function busca_banner_por_id($id)
	{
		// abre a tabela
		$db = $this->db('banners');
		
		// busca o banner
		$dados = $db->busca_por_id($id);
		
		//path e url da var modelo
		if($dados)
		{
			$this->url['modelo'] = $this->url['modelos'] . $dados->modelo .'/';
			$this->path['modelo'] = $this->path['modelos'] .DS. $dados->modelo;				
		}
		
		// retorno os dados 
		return $dados;
	}

	/* busca slide pelo id
	 ***************************************************/
	function busca_slide_por_id($id)
	{
		// abre a tabela
		$db = $this->db('slides');
		
		// busca o banner
		$dados = $db->busca_por_id($id);
		
		// carrega o arquivo
		if($dados)
		{
			$dados->ext = $dados->arquivo;
			$dados->arquivo = $this->url['uploads'] . "{$id}.{$dados->ext}";
			$dados->arquivo_base = $this->path['uploads'] .DS. "{$id}.{$dados->ext}";
		}
		
		// retorno os dados 
		return $dados;
	}
	
	
	/* busca todos os banners
	 ***************************************************/
	function busca_todos_banners($order = "nome ASC")
	{
		// abre a tabela
		$db = $this->db('banners');
		
		// busca o banner
		$dados = $db->busca_tudo($order);
		
		// retorno os dados 
		return $dados;
	}
	
	
	/* busca todos os slides
	 ***************************************************/
	function busca_todos_slides($idbanner, $somenteAtivos = true, $order = "ordem ASC, nome ASC")
	{
		// abre a tabela
		$db = $this->db('slides');
		
		$order = $order ? "ORDER BY $order" : "";
		$status = $somenteAtivos ? "AND status = '1'" : "";
		
		$sql = "WHERE idbanner = '$idbanner' $status $order";
		
		// busca o banner
		$slides = $db->busca($sql);
		
		$dados = array();
		foreach($slides as $slide)
			$dados[] = $this->busca_slide_por_id($slide->id);
		
		// retorno os dados 
		return $dados;
	}
	
	
	/* busca todos os modelos de banners 
	 ***************************************************/
	function busca_todos_modelos_banners()
	{
		$modelos = array();
		
		$modelos[1] = new stdClass();
		$modelos[1]->value = 'js.cycle.mod01';
		$modelos[1]->text = 'jQuery Cycle - Mod 01';
				
		// retorno os dados 
		return $modelos;
	}


	/* busca uma array de configuraçao do modelo
	 ***************************************************/
	function busca_config_modelo()
	{
		// abre o arquivo de configuração
		require($this->path['modelo'] .DS. 'config.php');
				
		// retorno os dados 
		return $config;
	}
	
	
	/* retorna valores default de uma tabela 
	 ***************************************************/
	function busca_default_values($tabela, $dados = array())
	{
		// carrega a tabela
		$tabela = $this->default_values[$tabela];
		
		// uni os dados
		$dados = array_merge($tabela, $dados);
		
		// inicia novo obj
		$obj = new stdClass();
		
		// loop nos campos
		foreach($dados as $k=>$v)
			$obj->$k = $v;
		
		// retorna o obj 
		return $obj;
	}	
	
	
	/* salva banner
	 ***************************************************/
	function salva_banner($id, $dados = array())
	{
		$db = $this->db('banners', $dados);
		$rt = array();
		
		// verifica se o registro já existe
		if($id)
		{
			// verifica se o usuario logado tem permissão
			jAccess('banners.editar');
			
			// atualiza os dados do registro
			$db->update();
			
			// carrega as vars de retorno
			$msg = 'Dados do banner foram atualizados com sucesso!';
		}
		else
		{
			// verifica se o usuario logado tem permissão
			jAccess('banners.adicionar');
				
			// cadastra o novo registro
			$db->insert();

			// carrega as vars de retorno
			$msg = 'Banner cadastrado com sucesso!';	
		}

		$rt['id'] = $db->id;
		$rt['msg'] = $msg;

		return $rt;
	}
	
	
	/* salva slide
	 ***************************************************/
	function salva_slide($dadosNome, $inputFile = 'file_upload')
	{		
		// carrega os dados
		$dados = JRequest::getvar($dadosNome, array(), 'array');
		
		jimport('joomla.filesystem.file');
		
		$file = JRequest::getVar($inputFile, null, 'files', 'array');
		$file_name = strtolower(JFile::makeSafe($file['name']));
		$file_ext = JFile::getExt($file_name);
		$file_src = $file['tmp_name'];
		$file_old = false;
		
		$id  = isset($dados['id']) ? $dados['id'] : 0;
		$msg = '';

		if((int) $dados['idbanner'])
		{
			// verifica se foi enviado algum arquivo
			if($file_src)
			{
				$banner = $this->db('banners');
				$banner = $this->busca_banner_por_id($dados['idbanner']);
				
				// busca config
				$config = $this->busca_config_modelo();
											
				// verifica ext permitidas
				if(!isset($config['arquivos.permitidos'][$file_ext]))
					$msg .= '- Tipo de arquivo não permitido, somente arquivos '. join(', ', $config['arquivos.permitidos']).'!<br>';
				
				// se for update
				if($id)
				{	
					// abre a tabela de slides
					$slide = $this->busca_slide_por_id($id);
					
					// ext do arquivo anterior
					$file_old = $slide ? $slide->arquivo_base : false;
				}
			
				// altera a nova ext
				$dados['arquivo'] = $file_ext;
			}	
		}
		else
			$msg .= '- ID do banner é inválido!<br>';

		if(!$id && !$file_src)
			$msg .= '- Arquivo não encontrado!<br>';

		if(empty($dados['nome']))
			$msg .= '- O campo \'Nome\' é obrigatório!<br>';

		if(!(int) $dados['ordem'])
			$msg .= '- O campo \'Ordem\' é obrigatório!<br>- O campo \'Ordem\' são permitidos somente números inteiros<br>';

		if(!empty($msg))
			return array('tipo' => 'error', 'msg' => 'Preencha corretamente o(s) seguinte(s) campo(s):<br><br>'.$msg);
		
		
		// abre a tabela de slides
		$db = $this->db('slides', $dados);
		
		// verifica se o registro já existe
		if($id)
		{
			// verifica se o usuario logado tem permissão
			jAccess('slides.editar');
			
			// atualiza os dados do registro
			$db->update();
			
			// carrega as vars de retorno
			$msg = 'Dados do slide foram atualizados com sucesso!';
		}
		else
		{
			// verifica se o usuario logado tem permissão
			jAccess('slides.adicionar');
				
			// cadastra o novo registro
			$db->insert();

			// carrega as vars de retorno
			$msg = 'Slide cadastrado com sucesso!';	
		}


		// upload
		if($file_src)
		{											
			$file_dest = $this->path['uploads'] .DS. "{$db->id}.{$file_ext}";
			if(JFile::upload($file_src, $file_dest))
			{
				// remove o arquivo antigo
				if($file_old && JFile::exists($file_old) && ($file_old != $file_dest))
					unlink($file_old);								
			}
			else
				$msg = "Dados atualizados, mas o arquivo não foi enviado!";
		}

		// retorno ok
		$r = array(
			'id' => $db->id,
			'idbanner' => $db->idbanner,
			'msg' => $msg
		);

		return $r;
	}
	
	
	/* remove banner
	 ***************************************************/
	function remover_banner($varIds)
	{
		$ids = JRequest::getvar($varIds, array(), 'array');

		if(count($ids) == 0)
			return array('tipo' => 'error', 'msg' => 'Nenhum banner foi selecionado!', 'retorno' => false);	
		
	
		$db = $this->db('banners');
		
		foreach($ids as $id)
		{
			$slides = $this->busca_todos_slides($id);
			
			foreach($slides as $slide)
				$this->remover_slide($slide->id, 'idUnique');
			
			// remove o registro
			$db->delete($id);

		}

		if(count($ids) == 1)
			$msg = 'Banner removido com sucesso!';
		else
			$msg = 'Banners removidos com sucesso!';
		
		
		$r = array(
			'ids' => $ids,
			'msg' => $msg,
			'retorno' => true
		);
			
		return $r;
	}
	

	/* remove slide
	 ***************************************************/
	function remover_slide($varIds, $method = 'request')
	{
		if($method == 'request')
			$ids = JRequest::getvar($varIds, array(), 'array');
		elseif($method == 'var')
			$ids = $varIds;		
		elseif($method == 'idUnique')
			$ids = array($varIds);
			

		if(count($ids) == 0)
			return array('tipo' => 'error', 'msg' => 'Nenhum slide foi selecionado!', 'retorno' => false);	
	
		jimport('joomla.filesystem.file');
	
		$db = $this->db('slides');
		
		foreach($ids as $id)
		{
			$b = $this->busca_slide_por_id($id);
			
			if($b)
			{
				// apaga o arquivo
				if(JFile::exists($b->arquivo_base))
					unlink($b->arquivo_base);
					
				// remove o registro
				$db->delete($id);
			}
		}

		if(count($ids) == 1)
			$msg = 'Slide removido com sucesso!';
		else
			$msg = 'Slides removidos com sucesso!';
		
		
		$r = array(
			'ids' => $ids,
			'msg' => $msg,
			'retorno' => true
		);
			
		return $r;
	}
		
	
}
?>