<?
// carrega o jcrud
jimport('edesktop.jcrud');

// inicia a class
class edesktop_produtos_imagens
{
	/* Object JCRUD
	 ***************************************************/
	public $db;



	/* nome da tabela de imagems
	 ***************************************************/
	private $tabela = 'jos_edesktop_produtos_imagens';
	


	/* Inicia a class
	 ***************************************************/
	function __construct()
	{
		// Abre a tabela
		$this->db = new JCRUD($this->tabela);
	}
	
	
	
	
	/* busca uma imagem pelo id
	 ***************************************************/
	function busca_por_id($id)
	{
		// imagem
		$dados = $this->db->busca_por_id($id);
				
		// retorno os dados 
		return $dados;
	}
	
	
	
	
	/* busca todas as imagens ignorando em destaque
	 * pelo id do produto
	 ***************************************************/
	function busca_por_produto($id)
	{
		// imagem
		$dados = $this->db->busca("WHERE idproduto = '{$id}' AND destaque != '1' AND status = '1'");
		
		foreach($dados as $d)
			$d->url = $this->caminho_imagem($d->id);
				
		// retorno os dados 
		return $dados;
	}
	
	
	
	
	/* busca a imagem em destaque pelo id do produto
	 ***************************************************/
	function busca_destaque_por_produto($id)
	{
		// imagem
		$dados = $this->db->busca("WHERE idproduto = '{$id}' AND destaque = '1' AND status = '1' LIMIT 0,1");
		
		if(count($dados))
			$dados[0]->url = $this->caminho_imagem($dados[0]->id);
		else
			$dados[0]->url = $this->caminho_imagem(0);
		
		// retorno os dados 
		return $dados[0];
	}




	/* retorna com o caminho da imagem
	 ***************************************************/
	private function caminho_imagem($id)
	{
		$img = "/media/com_edesktop/produtos/imagens/produtos/{$id}.jpg";
		$url = JURI::base(1). $img;
		
		if(!file_exists(JPATH_BASE. $img))
			$url = JURI::base(1). "/media/com_edesktop/imagens/404.jpg";
		
		// retorno os dados 
		return $url;
	}
}
?>