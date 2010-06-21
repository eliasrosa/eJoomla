<?
// carrega o jcrud
jimport('edesktop.jcrud');

// inicia a class
class edesktop_produtos_produtos
{
	/* Object JCRUD
	 ***************************************************/
	public $db;


	/* nome da tabela de produtos
	 ***************************************************/
	private $tabela = 'jos_edesktop_produtos_produtos';
	

	/* Paginação desativada
	 ***************************************************/
	public $paginacao = false;
	
	

	/* Inicia a class
	 ***************************************************/
	function __construct($dados = array())
	{
		// Abre a tabela
		$this->db = new JCRUD($this->tabela, $dados);
	}
	
	
	/* busca um produto pelo id
	 ***************************************************/
	function busca_por_id($id, $detalhado = false)
	{
		$dados = new stdClass();
		
		// produto
		$dados->produto = $this->db->busca_por_id($id);
		
		if($detalhado)
		{	
			// carrega o fabricante do produto
			jimport('edesktop.programas.produtos.fabricantes');
			$d = new edesktop_produtos_fabricantes();
			@$dados->fabricante = $d->busca_por_id($dados->produto->idfabricante);

			// carrega o imagem de destaque do produto
			jimport('edesktop.programas.produtos.imagens');
			$d = new edesktop_produtos_imagens();
			@$dados->imagem = $d->busca_destaque_por_produto($dados->produto->id);

			// carrega todas as imagens do produto
			jimport('edesktop.programas.produtos.imagens');
			$d = new edesktop_produtos_imagens();
			@$dados->imagens = $d->busca_por_produto($dados->produto->id);

			// carrega todos os textos do produto
			jimport('edesktop.programas.produtos.textos');
			$d = new edesktop_produtos_textos();
			@$dados->textos = $d->busca_por_produto($dados->produto->id);

			// retorno os dados 
			return $dados;
		}
		
		// retorno os dados 
		return $dados->produto;
	}
	

	/* apaga um produto pelo id
	 ***************************************************/
	function delete($id)
	{
		// textos
		$dados = $this->db->busca_por_id($id);
		$dados->status = '-1';
		
		$dados->update();
				
		// retorno os dados 
		return $dados;
	}
	
	
	

	/* salva o relacionamento dos produto com as categorias
	 ***************************************************/
	function salva_categorias($produto, $categorias)
	{
		$c = new JCRUD('jos_edesktop_produtos_categorias_rel');
		
		// apaga todos as categorias relacionadas com o produto
		$d = $c->delete($produto, 'idproduto', '');
		
		// 
		foreach($categorias as $idcategoria)
		{
			$r = $c;
			$r->idproduto = $produto;
			$r->idcategoria = $idcategoria;
			
			$r->insert(false);
		}
		
	}
	
	
	/* busca todas as categorias relacionadas
	 ***************************************************/
	function busca_categorias($idproduto)
	{
		$c = new JCRUD('jos_edesktop_produtos_categorias_rel');
		$categorias = $c->busca("WHERE idproduto = '{$idproduto}'");
		
		$r = array();
		
		foreach($categorias as $c)
			$r[] = $c->idcategoria;
		
		$r = join(',', $r);
		
		$r = $r == '' ? '0' : $r;
		
		return $r;
	}
		
	
	
	/* busca todos os produtos em destaques
	 ***************************************************/
	function busca_por_destaque()
	{
		$produtos = array();
		$where = "WHERE destaque = '1' AND status = '1'";
		
		if($this->paginacao)
		{
			$this->paginacao = $this->db->paginacao($where, $this->paginacao);
			$where = "$where LIMIT {$this->paginacao->limit}";
		}
		
		$pp = $this->db->busca($where);
		
		foreach($pp as $p)
		{
			$produtos[] = $this->busca_por_id($p->id, true);
		}
		
		return $produtos;
	}
	
	
	
	
	
	/* busca todos os produtos
	 ***************************************************/
	function busca_todos($order = "ORDER BY nome ASC")
	{
		$dados = $this->db->busca("WHERE status != '-1' " . $order);
		
		return $dados;
	}
	
	
	
	
	/* busca todos os produtos pelo texto
	 ***************************************************/
	function busca_por_texto($texto)
	{
		$produtos = array();
		
		
		$where = "WHERE (
			nome LIKE '%$texto%' OR 
			alias LIKE '%$texto%' OR 
			descricao LIKE '%$texto%' OR 
			referencia LIKE '%$texto%' OR 
			id LIKE '%$texto%' OR 
			metatagdescription LIKE '%$texto%' OR 
			metatagkey LIKE '%$texto%') AND status = '1'";
		
		if($this->paginacao)
		{
			$this->paginacao = $this->db->paginacao($where, $this->paginacao);
			$where = "$where LIMIT {$this->paginacao->limit}";
		}
				
		$pp = $this->db->busca($where);
		
		foreach($pp as $p)
		{
			$produtos[] = $this->busca_por_id($p->id, true);
		}
		
		return $produtos;
	}
	
	
	
	
	/* busca todos os produtos pelo id do fabricante
	 ***************************************************/
	function busca_por_fabricante($id)
	{
		$produtos = array();
		$where = "WHERE idfabricante = '{$id}' AND status = '1'";
		
		if($this->paginacao)
		{
			$this->paginacao = $this->db->paginacao($where, $this->paginacao);
			$where = "$where LIMIT {$this->paginacao->limit}";
		}

		$pp = $this->db->busca($where);
		
		foreach($pp as $p)
		{
			$produtos[] = $this->busca_por_id($p->id, true);
		}
		
		return $produtos;
	}


	
	
	/* busca todos os produtos pelo id da categoria
	 ***************************************************/
	function busca_por_categoria($id)
	{
		$produtos = array();
		
		// Abre a tabela
		$c = new JCRUD('jos_edesktop_produtos_categorias_rel');

		$where = "WHERE idcategoria = '{$id}'";
		
		if($this->paginacao)
		{
			$this->paginacao = $c->paginacao($where, $this->paginacao);
			$where = "$where LIMIT {$this->paginacao->limit}";
		}

		$pp = $c->busca($where);		
		foreach($pp as $p)
		{
			$produtos[] = $this->busca_por_id($p->idproduto, true);
		}
		
		return $produtos;
	}	




	/* busca todos os produtos pelo id da categoria pai
	 * e categorias filhas
	 ***************************************************/
	function busca_por_categorias($ids, $limit = 0)
	{
		$produtos = array();
		$ids = ($ids == '') ? 0 : $ids;
		
		// Abre a tabela
		$c = new JCRUD('jos_edesktop_produtos_categorias_rel');
		$where = "WHERE idcategoria IN ({$ids})";
		
		$where = $limit ? "$where ORDER BY RAND() LIMIT $limit" : $where;
				
		if($this->paginacao)
		{
			$this->paginacao = $c->paginacao($where, $this->paginacao);
			$where = "$where LIMIT {$this->paginacao->limit}";
		}

		$pp = $c->busca($where);
		
		foreach($pp as $p)
		{
			if(!isset($produtos[$p->idproduto]))
				$produtos[$p->idproduto] = $this->busca_por_id($p->idproduto, true);
		}
		
		return $produtos;
	}	
	
}
?>