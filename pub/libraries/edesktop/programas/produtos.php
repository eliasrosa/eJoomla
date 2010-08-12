<?
jimport('edesktop.programas.base');

class edProdutos extends eDesktopBasePrograma
{	
	public function __construct()
	{
		parent::__construct();

		$this->dqls->produtos = Doctrine_Query::create()
			->from('Produto p');
			
		$this->dqls->fabricantes = Doctrine_Query::create()
			->from('Fabricante f');
			
		$this->dqls->categorias = Doctrine_Query::create()
			->from('Categoria c');
			
		$this->dqls->imagens = Doctrine_Query::create()
			->from('Imagem i');
						
		$this->dqls->textos = Doctrine_Query::create()
			->from('Texto t');

		$this->dqls->produtos_ativos = Doctrine_Query::create()
			->from('Produto p')
			->innerJoin('p.Fabricante f WITH f.status = 1')
			->leftJoin('p.Imagens i WITH i.status = 1')
			->leftJoin('p.Textos t WITH t.status = 1')
			->where('p.status = 1 AND p.valor > 0')
			->orderBy('i.destaque DESC, t.ordem ASC');
			
		$this->dqls->fabricantes_ativos = Doctrine_Query::create()
			->from('Fabricante f')
			->where('f.status = 1');
			
		$this->dqls->categorias_ativas = Doctrine_Query::create()
			->from('Categoria c')
			->where('c.status = 1')
			->orderBy('c.ordem, c.idpai, c.nome');
			
		$this->dqls->imagens_ativas = Doctrine_Query::create()
			->from('Imagem i')
			->where('i.status = 1');
						
		$this->dqls->textos_ativos = Doctrine_Query::create()
			->from('Texto t')
			->where('t.status = 1');
			
		return $this;
	}
	
	
	
	public function getInstance()
	{
		$class = __CLASS__;		
		return new $class;
	}
		

	public function getUrl($tipo, $name = '')
	{
		$u['url.media'] = JURI::base().'media/com_edesktop/produtos/';
		$u['path.media'] = JPATH_BASE .DS. 'media' .DS. 'com_edesktop' .DS. 'produtos';
		
		$u['url.imagens'] = $u['url.media'] .'imagens/';
		$u['path.imagens'] = $u['path.media'] .DS. 'imagens';
		
		$u['url.fabricantes'] = $u['url.imagens'] .'fabricantes/' .$name. '.jpg';
		$u['path.fabricantes'] = $u['path.imagens'] .DS. 'fabricantes' .DS. $name .'.jpg';
		
		$u['url.produtos'] = $u['url.imagens'] .'produtos/' .$name. '.jpg';
		$u['path.produtos'] = $u['path.imagens'] .DS. 'produtos' .DS. $name .'.jpg';
		
		return $u[$tipo];		
	}	


	public function busca_produto_ativo_por_id($id)
	{
		$id = util::int($id);
		
		$this->query = $this->dqls->produtos_ativos
			->andWhere('p.id = ?', $id);
								
		return $this;
	}



	public function busca_produto_por_id($id)
	{
		$id = util::int($id);
		
		$this->query = $this->dqls->produtos
			->where('p.id = ?', $id);

		return $this;
	}


	
	public function busca_todos_produtos()
	{
		$this->query = $this->dqls->produtos;
		
		return $this;
	}



	public function busca_produtos_ativos_por_destaque($destaque = 1)
	{
		$destaque = util::int($destaque, -1);
		
		$this->query = $this->dqls->produtos_ativos
			->andWhere('p.destaque = ?', $destaque);
		
		return $this;
	}



	public function busca_produtos_ativos_por_search($busca)
	{
		$this->query = $this->dqls->produtos_ativos
			->andWhere('(p.nome LIKE ? OR p.alias LIKE ? OR p.descricao LIKE ? OR p.referencia LIKE ? OR p.metatagdescription LIKE ? OR p.metatagkey LIKE ?) OR (p.id = ?)', array("%$busca%", "%$busca%", "%$busca%", "%$busca%", "%$busca%", "%$busca%", $busca));
		
		return $this;		
	}


	public function busca_ids_categorias_filhas_ativas($id)
	{
		$id = util::int($id, -1);
		
		$dados = array();
		
		$filhas = edProdutos::getInstance()
					->busca_todas_categorias_ativas()
					->query
					->andWhere('idpai = ?', $id)
					->execute(array(), Doctrine_Core::HYDRATE_ARRAY);
		
		foreach($filhas as $filha)
		{
			$ids = $this->busca_ids_categorias_filhas_ativas($filha['id']);

			$dados = array_merge($dados, array($filha['id']));
		}

		$dados = array_merge(array($id), $dados);
		
		return $dados;
		
	}
	

	public function busca_produtos_ativos_por_categoria($id)
	{
		if(!is_array($id))
			$id = util::int($id, -1);
		
		// 
		$categoriasIDS = edProdutos::getInstance()
							->busca_ids_categorias_filhas_ativas($id);
							
		$this->query = Doctrine_Query::create()
						->from('Produto p')
						->innerJoin('p.Fabricante f WITH f.status = 1')
						->leftJoin('p.Categorias c')
						->whereIn('c.id', $id)
						->andWhere('p.status = 1 AND p.valor > 0')
						->groupBy('p.id');
							
		return $this;		
	}


	public function busca_produtos_ativos_por_fabricante($id)
	{
		$id = util::int($id);
		
		$this->query = $this->dqls->produtos_ativos
			->andWhere('p.idfabricante = ?', $id);
		
		return $this;		
	}



	public function busca_todas_categorias_ativas()
	{
		$this->query = $this->dqls->categorias_ativas;
		
		return $this;		
	}



	public function busca_todas_categorias()
	{
		$this->query = $this->dqls->categorias;
		
		return $this;		
	}



	public function busca_todos_fabricantes_ativos()
	{
		$this->query = $this->dqls->fabricantes_ativos;
		
		return $this;		
	}



	public function busca_categoria_por_id($id)
	{
		$id = util::int($id);
		
		$this->query = $this->dqls->categorias
			->where('c.id = ?', $id);
					
		return $this;
	}



	public function busca_categoria_ativa_por_id($id)
	{
		$id = util::int($id);
		
		$this->query = $this->dqls->categorias_ativas
			->andWhere('c.id = ?', $id);
						
		return $this;
	}



	public function busca_fabricante_ativo_por_id($id)
	{
		$id = util::int($id);
		
		$this->query = $this->dqls->fabricantes_ativos
			->andWhere('f.id = ?', $id);
						
		return $this;
	}



	public function busca_fabricante_por_id($id)
	{
		$id = util::int($id);
		
		$this->query = $this->dqls->fabricantes
			->where('f.id = ?', $id);
						
		return $this();
	}

}
?>