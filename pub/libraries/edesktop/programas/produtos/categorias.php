<?
// carrega o jcrud
jimport('edesktop.jcrud');

// inicia a class
class edesktop_produtos_categorias
{
	/* Object JCRUD
	 ***************************************************/
	private $db;




	/* nome da tabela de categorias
	 ***************************************************/
	private $tabela = 'jos_edesktop_produtos_categorias';




	/* Inicia a class
	 ***************************************************/
	function __construct()
	{
		// Abre a tabela
		$this->db = new JCRUD($this->tabela);
	}


	
	
	/* busca uma categoria pelo id
	 ***************************************************/
	function busca_por_id($id)
	{
		return $this->db->busca_por_id($id); 
	}
	


	
	/* busca todas as categorias pelo id do pai
	 ***************************************************/
	function busca_por_idpai($idpai)
	{
		return $this->db->busca("WHERE idpai = '{$idpai}' AND status = '1'");
	}




	/* busca todas as categorias filhas pelo id do pai,
	 * retornando uma string com os ids. ex: '14,74,57'
	 ***************************************************/
	function busca_ids($id = 0, $array = false)
	{
		$dados = $this->db->busca("WHERE id = '{$id}'");

		$filhas = $this->db->busca("WHERE idpai = '{$id}'");
		foreach($filhas as $filha)
		{
			$f = $this->busca_ids($filha->id, true);
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
}
?>