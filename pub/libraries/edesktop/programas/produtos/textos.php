<?
// carrega o jcrud
jimport('edesktop.jcrud');

// inicia a class
class edesktop_produtos_textos
{
	/* Object JCRUD
	 ***************************************************/
	public $db;



	/* nome da tabela de textos
	 ***************************************************/
	private $tabela = 'jos_edesktop_produtos_textos';
	


	/* Inicia a class
	 ***************************************************/
	function __construct($dados = array())
	{
		// Abre a tabela
		$this->db = new JCRUD($this->tabela, $dados);
	}
	
	
	
	
	/* busca um texto pelo id
	 ***************************************************/
	function busca_por_id($id)
	{
		// textos
		$dados = $this->db->busca_por_id($id);
				
		// retorno os dados 
		return $dados;
	}
	
	
	
	/* apaga um texto pelo id
	 ***************************************************/
	function delete($id)
	{
		// textos
		$dados = $this->db->delete($id);
				
		// retorno os dados 
		return $dados;
	}
		
	
	
	
	/* busca todos os textos pelo id do produto
	 ***************************************************/
	function busca_por_produto($id)
	{
		// textos
		$dados = $this->db->busca("WHERE idproduto = '{$id}' AND status = '1' ORDER BY ordem ASC");
						
		// retorno dos dados 
		return $dados;
	}
}
?>