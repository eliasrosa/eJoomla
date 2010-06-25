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
			'allow' => 'jpg, gif, swf',
			'params' => ''
		),
		
		// tabela slides
		'slides' => array(
			'id' => 0,
			'idbanner' => 0,
			'nome' => '',
			'arquivo' => '',
			'url' => '',
			'order' => '1',
			'status' => 1,
		)
	);
	

	/* caminho da pasta de uploads
	 ***************************************************/
	public $pasta = "/media/com_edesktop/banners/uploads";



	/* inicia a class
	 ***************************************************/
	function __construct(){}
	
	
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
			$dados->arquivo = JURI::base(1)."{$this->pasta}/{$id}.{$dados->ext}";
			$dados->arquivo_base = JPATH_BASE."{$this->pasta}/{$id}.{$dados->ext}";
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
		$dados = $db->busca($sql);
		
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
		
		$modelos[2] = new stdClass();
		$modelos[2]->value = 'js.cycle.mod02';
		$modelos[2]->text = 'jQuery Cycle - Mod 02';		
		
		// retorno os dados 
		return $modelos;
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
				
				// separa as extenssões e limpa usando trim
				$allow = explode(',', $banner->allow);
				foreach($allow as $k=>$v)
					$allow[trim($v)] = trim($v);
			
				// verifica ext permitidas
				if(!isset($allow[$file_ext]))
					$msg .= '- Tipo de arquivo não permitido, somente arquivos ('.$banner->allow.')!<br>';
				
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
			$file_dest = JPATH_BASE . "{$this->pasta}/{$db->id}.{$file_ext}";
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