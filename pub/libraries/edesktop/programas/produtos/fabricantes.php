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
	
	
	/* busca todos os fabricantes
	 ***************************************************/
	function busca_todos($limit = '')
	{
		$limit = empty($limit) ? '' : "LIMIT 0,{$limit}";
		$dados = $this->db->busca("WHERE status = '1' $limit");
		
		foreach($dados as $f)
			$f->imagem = $this->caminho_imagem($f->id);
		
		return $dados;
	}
	

	/* retorna com o caminho da imagem
	 ***************************************************/
	private function caminho_imagem($id)
	{
		$img = "/media/com_edesktop/loja/imagens/fabricantes/{$id}.jpg";
		$url = JURI::base(1). $img;
				
		if(!file_exists(JPATH_BASE. $img))
			$url = JURI::base(1). "/media/com_edesktop/loja/imagens/404.jpg";
		
		// retorno os dados 
		return $url;
	}
	
	
}
?>