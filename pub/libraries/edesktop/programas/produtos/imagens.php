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
	
	
	/* nome da tabela de imagems
	 ***************************************************/
	public $pasta = "/media/com_edesktop/produtos/imagens/produtos";


	/* Inicia a class
	 ***************************************************/
	function __construct($dados = array())
	{
		// Abre a tabela
		$this->db = new JCRUD($this->tabela, $dados);
	}
	
	
	
	/* busca uma imagem pelo id
	 ***************************************************/
	function busca_por_id($id)
	{
		// imagem
		$dados = $this->db->busca_por_id($id);
		
		// imagem
		$dados->url = $this->caminho_imagem($id);

		// retorno os dados 
		return $dados;
	}
	

	/* apaga uma imagem pelo id
	 ***************************************************/
	function delete($id)
	{
		$url = $this->caminho_imagem($id, false);
		if($url)
		{
			$url = JPATH_BASE . str_replace('/ejoomla', '', $url);
			
			if(file_exists($url))
				unlink($url);				
		}

		// remove do banco
		$dados = $this->db->delete($id);
		
		// retorno os dados 
		return $dados;
	}

	
	
	
	/* busca todas as imagens ignorando em destaque
	 * pelo id do produto
	 ***************************************************/
	function busca_por_produto($id, $todas = false)
	{
		// busca tudo
		$where = $todas ? "": "AND destaque != '1' AND status = '1'";
		
		// imagem
		$dados = $this->db->busca("WHERE idproduto = '{$id}' {$where}");
		
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
	private function caminho_imagem($id, $img404 = true)
	{
		$img = $this->pasta . "/{$id}.jpg";
		$url = JURI::base(1). $img;
		
		if(!file_exists(JPATH_BASE. $img))
		{
			if($img404)
				$url = JURI::base(1). "/media/com_edesktop/imagens/404.jpg";
			else
				$url = false;
		}
			
		// retorno os dados 
		return $url;
	}
}
?>