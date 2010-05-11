<?
// carrega o jcrud
jimport('edesktop.jcrud');

// inicia a class
class edesktop_loja_cupons
{
	/* Object JCRUD
	 ***************************************************/
	public $db;



	/* nome da tabela de textos
	 ***************************************************/
	private $tabela = 'jos_edesktop_loja_cupons';
	


	/* Inicia a class
	 ***************************************************/
	function __construct()
	{
		// Abre a tabela
		$this->db = new JCRUD($this->tabela);
	}
	
	
	
	/* busca cupom pelo codigo
	 ***************************************************/
	function busca($cod)
	{
		// textos
		$dados = $this->db->busca("WHERE codigo = '$cod' AND CURDATE() <= vencimento AND status = '1' LIMIT 0,1");
				
		// retorno os dados 
		return count($dados) ? $dados[0] : false;
	}
	
}
?>