<?php

// evitar acesso direto
defined( '_JEXEC' ) or die( 'Acesso restrito' );
 
jimport( 'joomla.application.component.view');
 
class edesktopVIEWloja extends JView
{
    function display($tpl = null)
    { 
		// carreca a class de configurações
		jimport('edesktop.programas.loja.config');
		
		// carrega a class de configurações
		$this->config = new edesktop_loja_config();
		
		// adiciona o style css da loja
		JHTML::stylesheet('style.css', 'media/com_edesktop/loja/css/');
		
		// carega o menu		
		$menu =& JSite::getMenu();
		
		// carrega parâmetros do menu
		$menuItem =& $menu->getActive();	
		$this->assignRef('menu', $menuItem);
		
		// carrega parâmetros
		$params = $menu->getParams($menuItem->id);		
		$this->assignRef('params', $params);
		
		// carrega parâmetros do menu da loja
		$itemid = JRequest::getvar('Itemid');
		$menu =& JSite::getMenu();
		$menuItem =& $menu->getItem($itemid);
		$params = $menu->getParams($menuItem->id);
		$itemid = ($params->get('Itemid')) ? $params->get('Itemid') : $itemid;
		$this->assignRef('itemid', $itemid);		
		
		// carrega o layout
		$layout = JRequest::getvar('layout');
						
		// paths dos arquivos de layout
		$file_layout = dirname(__FILE__) .DS. 'tmpl' .DS. "$layout.php";
		$file_view = dirname(__FILE__) .DS. 'views' .DS. "view.$layout.php";	
		
		// verifica se o aquivo de layout existe
		if(file_exists($file_layout))
		{			
			// abre o view do layout
			require_once($file_view);
		}
				
		// carrega o template
        parent::display($tpl);
	
	}
	
			
	private function carrinho_busca_produto()
	{
		// importa a class produtos
		jimport('edesktop.programas.loja');	
		
		// ID do produtos
		$id = JRequest::getInt('id', 0);		
		
		// inicia no obj
		$produto = edProdutos::getInstance()
						->busca_produto_ativo_por_id($id)
						-fetchOne();
			
		// verifica o produto
		if(!$produto)
			die( 'Produto inválido' );
		
			
		// cria uma class de retorno
		$r = new stdClass();
				
		// adiciona o produto
		$r->db = new stdClass();
		
		$r->db->id = $produto->id;
		$r->db->nome = $produto->nome;
		$r->db->valor = $produto->valor;
		$r->db->frete = $produto->frete;
		$r->db->peso = $produto->peso;
		$r->db->imagem = $produto->imagem->url;
		
		
		// cria uma class do carrinho
		$r->carrinho = new stdClass();

		// carrega as opções
		$r->carrinho->op = JRequest::getVar('op', array());	
		
		// carrega a ref caso exista
		if(isset($r->carrinho->op['Ref']))
		{
			$ref =  ' - Ref. ' .$r->carrinho->op['Ref'];
			unset($r->carrinho->op['Ref']);
		}else
			$ref = '';
			
			
		$op = implode(' ', $r->carrinho->op).$ref;
		$op = ($op == '') ? '' : $op;
		
		
		// Nome do produto com opções
		$r->carrinho->nome = "{$produto->nome} {$op}";
		$r->carrinho->descricao = "{$produto->nome} {$op}";
			

		// ID do carrinho
		$r->carrinho->id = substr(sha1(md5($produto->id .':'. $r->carrinho->nome)), 0, 10);
		
		
		// retorna tudo
		return $r;
				
	}
			
		
}

?>