<?
// carrega o jcrud
jimport('edesktop.jcrud');

// inicia a class
class edesktop_produtos_produtos
{
	/* Object JCRUD
	 ***************************************************/
	private $db;


	/* nome da tabela de produtos
	 ***************************************************/
	private $tabela = 'jos_edesktop_produtos_produtos';


	/* Inicia a class
	 ***************************************************/
	function __construct()
	{
		// Abre a tabela
		$this->db = new JCRUD($this->tabela);
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
			$fabricante = new edesktop_produtos_fabricantes();
			$dados->fabricante = $fabricante->busca_por_id($dados->produto->idfabricante);
			
			// retorno os dados 
			return $dados;
		}
		
		// retorno os dados 
		return $dados->produto;
	}
	
	
	
	
	/* busca todos os produtos em destaques
	 ***************************************************/
	function busca_por_destaque()
	{
		$produtos = array();
		$pp = $this->db->busca("WHERE destaque = '1' AND status = '1'");
		
		foreach($pp as $p)
		{
			$produtos[] = $this->busca_por_id($p->id, true);
		}
		
		return $produtos;
	}
	
	
	
	
	/* busca todos os produtos pelo texto
	 ***************************************************/
	function busca_por_texto($texto)
	{
		$produtos = array();
		$pp = $this->db->busca("WHERE (
			nome LIKE '%$texto%' OR 
			alias LIKE '%$texto%' OR 
			metatagdescription LIKE '%$texto%' OR 
			metatagkey LIKE '%$texto%') AND status = '1'");
		
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
		$pp = $this->db->busca("WHERE idfabricante = '{$id}' AND status = '1'");
		
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
		$pp = $c->busca("WHERE idcategoria = '{$id}'");
		
		foreach($pp as $p)
		{
			$produtos[] = $this->busca_por_id($p->idproduto, true);
		}
		
		return $produtos;
	}	




	/* busca todos os produtos pelo id da categoria pai
	 * e categorias filhas
	 ***************************************************/
	function busca_por_categorias($ids)
	{
		$produtos = array();
		
		// Abre a tabela
		$c = new JCRUD('jos_edesktop_produtos_categorias_rel');
		$pp = $c->busca("WHERE idcategoria IN ({$ids})");
		
		foreach($pp as $p)
		{
			$produtos[] = $this->busca_por_id($p->idproduto, true);
		}
		
		return $produtos;
	}	
	
}
?>