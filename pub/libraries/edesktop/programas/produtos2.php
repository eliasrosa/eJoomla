<?
jimport('edesktop.programas.base');

class edProdutos2 extends eDesktoBase
{
	public function getUrl($tipo, $name = '')
	{
		$u['404'] = JURI::base(1).'/media/com_edesktop/imagens/404.jpg';

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



	public function busca_produto_id($id)
	{
		$id = util::int($id);
		
		if($this->isAdmin)
			$this->query = Doctrine_Query::create()
				->from('Produto p')
				->where('p.id = ?', $id);
		else
			$this->query = Doctrine_Query::create()
				->from('Produto p')
				->innerJoin('p.Fabricante f WITH f.status = 1')
				->where('p.id = ?', $id)
				->andWhere('p.status = 1');
						
		
		return $this->query->fetchOne();
	}


	
	public function busca_todos_produtos()
	{
		if($this->isAdmin)
			$this->query = Doctrine_Query::create()
				->from('Produto as p');
		else
			$this->query = Doctrine_Query::create()
				->from('Produto p')
				->innerJoin('p.Fabricante f WITH f.status = 1')
				->where('p.status = 1');
			 			
		$this->createPager();
		
		return $this->pagerLayout;
	}



	public function busca_produtos_por_destaque($dest = 1)
	{
		$dest = util::int($dest);
		
		if($this->isAdmin)
			$this->query = Doctrine_Query::create()
				->from('Produto as p')
				->where('p.destaque = ?', $dest);
		else
			$this->query = Doctrine_Query::create()
				->from('Produto p')
				->innerJoin('p.Fabricante f WITH f.status = 1')
				->where('p.destaque = ?', $dest)
				->andWhere('p.status = 1');
						
		$this->createPager();
		
		return $this->pagerLayout;
	}



	public function busca_produtos_por_fabricante($id)
	{
		$id = util::int($id);
		
		if($this->isAdmin)
			$this->query = Doctrine_Query::create()
				->from('Produto as p')
				->where('p.idfabricante = ?', $id);
		else
			$this->query = Doctrine_Query::create()
				->from('Produto p')
				->innerJoin('p.Fabricante f WITH f.status = 1')
				->where('p.idfabricante = ?', $id)
				->andWhere('p.status = 1');
						
		$this->createPager();
		
		return $this->pagerLayout;		
	}



	public function busca_todas_categorias_ativas()
	{
		$this->query = Doctrine_Query::create()->from('Categoria');
		
		$this->createPager();
		
		return $this->pagerLayout;		
	}

	
	public function busca_produtos_por_search(){}
	public function busca_produtos_por_categorias(){}
	public function salvar_produto(){}
	public function excluir_produto(){}
	
}
?>