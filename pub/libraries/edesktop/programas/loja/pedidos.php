<?
// carrega o jcrud
jimport('edesktop.jcrud');

// inicia a class
class edesktop_loja_pedidos
{
	/* Object JCRUD
	 ***************************************************/
	public $db;



	/* nome da tabela de pedidos
	 ***************************************************/
	private $tabela = 'jos_edesktop_loja_pedidos';
	


	/* Inicia a class
	 ***************************************************/
	function __construct()
	{
		// Abre a tabela
		$this->db = new JCRUD($this->tabela);
	}
	
	
	
	/* Salva os dados da array no tabela de pedido
	 ***************************************************/
	function salvar($dados)
	{	
		$pedido = new JCRUD($this->tabela, $dados);
		
		if($pedido->id)
			$pedido->update();
		else
			$pedido->insert();
			
	
	
		// salva os itens do pedido
		if(isset($dados['itens']))
		{
			foreach($dados['itens'] as $item)
			{
				$dadosItem = array( 
					'idPedido' => $pedido->id,
					'nome' => $item['nome'],
					'valor' => $item['valor'],
					'valorOriginal' => $item['valorOriginal'],
					'quantidade' => $item['quantidade']
				);
							
				$this->adicionarItem($dadosItem);
			}	
		}
		
		return $pedido;
	}
	
	
	/* Busca o pedido pelo ID do pedido
	 ***************************************************/
	function busca_por_id($id)
	{	
		$dados = $this->db->busca_por_id($id);
		
		return $dados;
	}
		

	/* Busca o pedido pelo ID da Trasação do pedido
	 ***************************************************/
	function busca_por_transacaoID($pedido, $email)
	{	
		$dados = $this->db->busca("WHERE TransacaoID = '{$pedido}' AND CliEmail = '{$email}' LIMIT 0,1");
		
		return count($dados) ? $dados[0] : false;
	}
	
	
		
	/* Adiciona um item no pedido
	 ***************************************************/
	function adicionarItem($item)
	{	
		$i = new JCRUD('jos_edesktop_loja_pedidos_itens', $item);
		
		return $i->insert();

	}		
	
	
	
}
?>