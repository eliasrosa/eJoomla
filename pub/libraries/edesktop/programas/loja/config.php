<?
// carrega o jcrud
jimport('edesktop.jcrud');

// inicia a class
class edesktop_loja_config
{
	/* Object JCRUD
	 ***************************************************/
	public $db;



	/* nome da tabela de textos
	 ***************************************************/
	private $tabela = 'jos_edesktop_loja_configuracoes';
	


	/* Inicia a class
	 ***************************************************/
	function __construct()
	{
		// Abre a tabela
		$this->db = new JCRUD($this->tabela);
	}
	
	
	
	/* busca configurações
	 ***************************************************/
	function get($var)
	{
		// textos
		$dados = $this->db->busca_por_id($var, 'var');
				
		// retorno os dados 
		return $dados->value;
	}
	
}
?>