<?
// carrega o jcrud
jimport('edesktop.jcrud');

// inicia a class
class edesktop_produtos_categorias
{
	/* Object JCRUD
	 ***************************************************/
	public $db;




	/* nome da tabela de categorias
	 ***************************************************/
	private $tabela = 'jos_edesktop_produtos_categorias';




	/* Inicia a class
	 ***************************************************/
	function __construct($dados = '')
	{
		// Abre a tabela
		$this->db = new JCRUD($this->tabela, $dados);
	}


	
	
	/* busca uma categoria pelo id
	 ***************************************************/
	function busca_por_id($id)
	{
		return $this->db->busca_por_id($id); 
	}
	


	/* apaga uma categoria pelo id
	 ***************************************************/
	function delete($id)
	{
		// textos
		$dados = $this->db->delete($id);
				
		// retorno os dados 
		return $dados;
	}


	
	
	/* busca todas as categorias
	 ***************************************************/
	function busca_todas()
	{
		// textos
		$dados = $this->db->busca("ORDER BY nome ASC");
						
		// retorno dos dados 
		return $dados;
	}



	
	/* busca todas as categorias pelo id do pai
	 ***************************************************/
	function busca_por_idpai($idpai)
	{
		return $this->db->busca("WHERE idpai = '{$idpai}' AND status = '1' ORDER BY ordem ASC, nome ASC");
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
	
	public function cria_lista_simples($idpai = 0)
	{
		$cats = $this->busca_por_idpai($idpai);		
		$m = '';
		
		if(count($cats))
		{
			$class = ($idpai != 0) ? '' : ' class="lista"';
			$m .= "<ul{$class}>";
			
			foreach($cats as $cat)
			{
				$s = $this->cria_lista_simples($cat->id);
				$class = ($s == '') ? '' : ' class="pai"';
				
				// adiciona o link
				$m .= "<li{$class}><a href=\"javascript:void(0);\" rel=\"{$cat->id}\" title=\"{$cat->nome}\">{$cat->nome}</a>{$s}</li>";
			}
						
			$m .= "</ul>";
		}
			
		return $m;
	}
	
	
	
	public function cria_select_simples($idpai = 0, $attrs = '', $raiz = false, $checked = '', $nivel = 0)
	{
		$cats = $this->db->busca("WHERE idpai = '{$idpai}' ORDER BY ordem ASC, nome ASC");		
		$m = '';

		if($nivel == 0)
		{
			$m .= "<select {$attrs}>";
			
			// is checked
			$check = $checked == 0 ? ' selected="selected"' : '';
		
			if($raiz)
				$m .= "<option value=\"0\"{$check}>{$raiz}</option>";
		}
		
		if(count($cats))
		{			
			foreach($cats as $cat)
			{	
				$space = $nivel ? str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $nivel) .'-&nbsp;&nbsp;' : '';
			
				// is checked
				$check = $checked == $cat->id ? ' selected="selected"' : '';
								
				// adiciona o link
				$m .= "<option value=\"{$cat->id}\" rel=\"{$cat->id}\"{$check}>{$space}{$cat->nome}</option>";
				
				// adiciona subcategorias caso exista
				$m .= $this->cria_select_simples($cat->id, $attrs, $raiz, $checked, $nivel + 1);
			}
		}
					
		if($nivel == 0)
			$m .= "</select>";
			
		return $m;
	}		
}
?>