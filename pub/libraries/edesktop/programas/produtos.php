<?
// carrega o jcrud
jimport('edesktop.jcrud');

// carrega a paginacao
jimport('edesktop.jcrud.paginacao');

// carrega a paginacao
jimport('edesktop.util');

// inicia a class
class edProdutos
{
	var $paginacao = null;


	/* tabelas
	 ***************************************************/
	private $tabelas = array(
		'produtos' => 'jos_edesktop_produtos_produtos',
		'fabricantes' => 'jos_edesktop_produtos_fabricantes',
		'imagens' => 'jos_edesktop_produtos_imagens',
		'textos' => 'jos_edesktop_produtos_textos',
		'categorias' => 'jos_edesktop_produtos_categorias',
		'categorias_rel' => 'jos_edesktop_produtos_categorias_rel'
	);

	

	/* caminhos das pastas
	 ***************************************************/
	public $url = array();
	public $path = array();



	/* inicia a class
	 ***************************************************/
	function __construct()
	{
		$this->url['img404'] = JURI::base()."media/com_edesktop/imagens/404.jpg";
		
		$this->url['media'] = JURI::base()."media/com_edesktop/produtos/";
		$this->path['media'] = JPATH_BASE .DS. 'media' .DS. 'com_edesktop' .DS. 'produtos';
		
		$this->url['imagens'] = $this->url['media'] .'imagens/';
		$this->path['imagens'] = $this->path['media'] .DS. 'imagens';

		$this->url['fabricantes'] = $this->url['imagens'] .'fabricantes/';
		$this->path['fabricantes'] = $this->path['imagens'] .DS. 'fabricantes';

		$this->url['produtos'] = $this->url['imagens'] .'produtos/';
		$this->path['produtos'] = $this->path['imagens'] .DS. 'produtos';
		
		// carrega a paginacao
		$this->paginacao = new paginacao();
	}

	
	
	/* carrega o DB da tabela selecionada
	 ***************************************************/
	function db($tabela, $dados = array())
	{
		// Abre a tabela
		return new JCRUD($this->tabelas[$tabela], $dados);
	}

	

	/* busca todas as categorias filhas pelo id do pai,
	 * retornando uma string com os ids. ex: '14,74,57'
	 ***************************************************/
	function busca_ids_categorias_filhas($id = 0, $array = false)
	{
		$id = util::int($id, -1);
	
		$db = $this->db('categorias');
		$dados = $db->busca("WHERE id = '{$id}'");
		$filhas = $db->busca("WHERE idpai = '{$id}'");
		foreach($filhas as $filha)
		{
			$f = $this->busca_ids_categorias_filhas($filha->id, true);
			$dados  = array_merge($dados, $f);
		}
	
		if($array)
			return $dados;
		else
		{
			$retorno = array();

			foreach ($dados as $item)
				$retorno[] = $item->id;

			return join(',', $retorno);		
		}
	}
	


	/* busca todos os produtos pelo ids da categorias,
	 * retornando uma string com os ids. ex: '14,74,57'
	 ***************************************************/
	function busca_ids_produtos_por_ids_categorias($ids, $retorno = 'join')
	{
		$ids = $ids == '' ? -1 : $ids;
		
		$db = $this->db('categorias_rel');
		$dados = $db->busca("WHERE idcategoria IN ({$ids}) GROUP BY idproduto");
			
		$r = array();
		
		foreach ($dados as $item)
			$r[] = $item->idproduto;

		if($retorno == 'join')
			return join(',', $r);	

		elseif($retorno == 'array')
			return $r;	
	}
	


	/* Busca todos os produtos pelo id de uma categoria,
	 * e de categrias filhas
	 ***************************************************/ 
	function busca_produtos_por_categoria($id = -1, $sql = "", $tabelas_relacionadas = array())
	{
		$id = util::int($id, -1);
		
		// carrega ids das categorias filhas
		$categoriasIDS = $this->busca_ids_categorias_filhas($id);
		
		// carrega ids dos produtos
		$produtosIDS = $this->busca_ids_produtos_por_ids_categorias($categoriasIDS);
		
		// 
		if(empty($produtosIDS))
			return array();
		
		// abre a tabela
		$db = $this->db('produtos');
		
		// busca os registros
		$dados = $db->busca("WHERE id IN({$produtosIDS}) {$sql}");
		
		// inicia a paginação
		$this->paginacao->init(count($dados));
		
		$retorno = array();
		for($i = $this->paginacao->row_inicio; $i <= $this->paginacao->row_fim; $i++)
			if(isset($dados[$i]))
				$retorno[] = $this->busca_produto_por_id($dados[$i]->id, "", $tabelas_relacionadas);
	
		return $retorno;
	}



	/* 
	 ***************************************************/ 
	function busca_produtos_em_destaque($sql = "", $tabelas_relacionadas = array())
	{		
		$db = $this->db('produtos');
		$dados = $db->busca("WHERE destaque = '1' {$sql}");
				
		// inicia a paginação
		$this->paginacao->init(count($dados));
		
		$retorno = array();
		for($i = $this->paginacao->row_inicio; $i <= $this->paginacao->row_fim; $i++)
			if(isset($dados[$i]))
				$retorno[] = $this->busca_produto_por_id($dados[$i]->id, "", $tabelas_relacionadas);
		
		return $retorno;
	}



	/* Busca os dados do produto pelo id
	 ***************************************************/	
	function busca_produto_por_id($id = 0, $sql = "", $tabelas = array())
	{
		$id = util::int($id, -1);

		$dados = new stdClass();
		
		$db = $this->db('produtos');
		$dados->produto = $db->busca("WHERE id = '{$id}' {$sql}");
		$dados->produto = count($dados->produto) ? $dados->produto[0] : false;
		
		if($dados->produto && count($tabelas))
		{	
			// produtos
			$produto = $dados->produto;
			
			if(isset($tabelas['fabricante']))
				$dados->fabricante = $this->busca_fabricante_por_id($produto->idfabricante, $tabelas['fabricante']);
			elseif(in_array('fabricante', $tabelas))
				$dados->fabricante = $this->busca_fabricante_por_id($produto->idfabricante, '');


			if(isset($tabelas['imagem']) || in_array('imagem', $tabelas))
				$dados->imagem = $this->busca_imagem_destaque_por_produto($produto->id);


			if(isset($tabelas['imagens']))
				$dados->imagens = $this->busca_imagens_por_produto($produto->id, $tabelas['imagens']);
			elseif(in_array('imagens', $tabelas))
				$dados->imagens = $this->busca_imagens_por_produto($produto->id, "AND status = '1'");


			if(isset($tabelas['textos']))
				$dados->textos = $this->busca_textos_por_produto($produto->id, $tabelas['textos']);
			elseif(in_array('textos', $tabelas))
				$dados->textos = $this->busca_textos_por_produto($produto->id, "AND status = '1' ORDER BY ordem ASC");
			
			// retorno os dados 
			return $dados;
		}
		
		// retorno os dados 
		return $dados->produto;
	}



	function busca_fabricante_por_id($id, $sql = "")
	{
		$id = util::int($id, -1);
		
		$db = $this->db('fabricantes');
		$dados = $db->busca("WHERE id = '{$id}' {$sql}");
		$dados = count($dados) ? $dados[0] : false;

		return $dados;
	}



	function busca_imagem_por_id($id, $sql = "")
	{
		$id = util::int($id, -1);

		$db = $this->db('imagens');
		$dados = $db->busca("WHERE id = '{$id}' {$sql}");
		$dados = count($dados) ? $dados[0] : false;

		if($dados)
			$dados->url = $this->busca_imagem_path($id);
		else
			$dados->url = $this->busca_imagem_path('');
			
		return $dados;
	}



	function busca_texto_por_id($id, $sql = "")
	{
		$id = util::int($id, -1);		
		
		$db = $this->db('textos');
		$dados = $db->busca("WHERE id = '{$id}' {$sql}");
		$dados = count($dados) ? $dados[0] : false;
			
		return $dados;
	}

	
	
	function busca_categoria_por_id($id, $sql = "")
	{
		$id = util::int($id, -1);

		$db = $this->db('categorias');
		$dados = $db->busca("WHERE id = '{$id}' {$sql}");
		$dados = count($dados) ? $dados[0] : false;
		
		return $dados;
	}



	/* busca a imagem em destaque pelo id do produto
	 ***************************************************/
	function busca_imagem_destaque_por_produto($id)
	{
		$id = util::int($id, -1);

		$db = $this->db('imagens');
		$dados = $db->busca("WHERE idproduto = '{$id}' AND status = '1' ORDER BY destaque DESC LIMIT 0,1");
		
		if(count($dados))
			$dados[0]->url = $this->busca_imagem_path($dados[0]->id);
		else
			$dados[0]->url = $this->busca_imagem_path('');
		
		// retorno os dados 
		return $dados[0];
	}
	
	
	function busca_produtos_por_fabricante($id = 0, $sql = "", $tabelas_relacionadas = array())
	{
		$id = util::int($id, -1);
		
		$db = $this->db('produtos');
		$dados = $db->busca("WHERE idfabricante = '{$id}' {$sql}");

		// inicia a paginação
		$this->paginacao->init(count($dados));
		
		$retorno = array();
		for($i = $this->paginacao->row_inicio; $i <= $this->paginacao->row_fim; $i++)
			if(isset($dados[$i]))
				$retorno[] = $this->busca_produto_por_id($dados[$i]->id, "", $tabelas_relacionadas);
		
		return $retorno;
	}


	function busca_imagens_por_produto($id = 0, $sql = "")
	{
		$id = util::int($id, -1);
		
		$db = $this->db('imagens');
		$dados = $db->busca("WHERE idproduto = '$id' {$sql}");

		// inicia a paginação
		$this->paginacao->init(count($dados));
		
		$retorno = array();
		for($i = $this->paginacao->row_inicio; $i <= $this->paginacao->row_fim; $i++)
			if(isset($dados[$i]))
				$retorno[] = $this->busca_imagem_por_id($dados[$i]->id);
		
		return $retorno;
	}
	

	function busca_textos_por_produto($id = 0, $sql = "")
	{
		$id = util::int($id, -1);
		
		$db = $this->db('textos');
		$dados = $db->busca("WHERE idproduto = '{$id}' {$sql}");

		// inicia a paginação
		$this->paginacao->init(count($dados));
		
		$retorno = array();
		for($i = $this->paginacao->row_inicio; $i <= $this->paginacao->row_fim; $i++)
			if(isset($dados[$i]))
				$retorno[] = $this->busca_texto_por_id($dados[$i]->id);
		
		return $retorno;
	}
	
	
	function busca_produtos_por_texto($texto = '', $sql = "", $tabelas_relacionadas = array())
	{
		$texto = util::quote($texto);
		
		if($texto == '')
			return array();
		
		$where = "WHERE
			(nome LIKE '%$texto%' OR 
			alias LIKE '%$texto%' OR 
			descricao LIKE '%$texto%' OR 
			referencia LIKE '%$texto%' OR 
			id LIKE '%$texto%' OR 
			metatagdescription LIKE '%$texto%' OR 
			metatagkey LIKE '%$texto%')";

		$db = $this->db('produtos');
		$dados = $db->busca("{$where} {$sql}");

		// inicia a paginação
		$this->paginacao->init(count($dados));
		
		$retorno = array();
		for($i = $this->paginacao->row_inicio; $i <= $this->paginacao->row_fim; $i++)
			if(isset($dados[$i]))
				$retorno[] = $this->busca_produto_por_id($dados[$i]->id, "", $tabelas_relacionadas);
		
		return $retorno;
	}
	
	
	/* retorna com o caminho da imagem
	 ***************************************************/
	private function busca_imagem_path($id, $img404 = true)
	{
		$id = util::int($id, -1);
		
		$img = $this->path['produtos'] .DS. "{$id}.jpg";
		$url = $this->url['produtos'] . "{$id}.jpg";
		
		if(!file_exists($img))
		{
			if($img404)
				$url = $this->url['img404'];
			else
				$url = false;
		}
			
		// retorno os dados 
		return $url;
	}	
}
?>