<?
// carrega o jcrud
jimport('edesktop.jcrud');

// inicia a class
class edesktop_produtos_fabricantes
{
	/* Object JCRUD
	 ***************************************************/
	private $db;


	/* nome da tabela
	 ***************************************************/
	private $tabela = 'jos_edesktop_produtos_fabricantes';


	/* Inicia a class
	 ***************************************************/
	function __construct()
	{
		// Abre a tabela
		$this->db = new JCRUD($this->tabela);
	}
	
	
	/* busca um fabricantes pelo id
	 ***************************************************/
	function busca_por_id($id)
	{
		$r = $this->db->busca_por_id($id);
		return $r;
	}
}
?>