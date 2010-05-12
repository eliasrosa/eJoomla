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
				
		// importa a class produtos
		jimport('edesktop.programas.produtos.produtos');
		
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
			// inicia no obj produtos
			$produtos = new edesktop_produtos_produtos();
			
			// abre o view do layout
			require_once($file_view);
		}
				
		// carrega o template
        parent::display($tpl);
	
	}
	
			
	private function carrinho_busca_produto()
	{
		// importa a class produtos
		jimport('edesktop.programas.produtos.produtos');	

		// inicia no obj
		$db = new edesktop_produtos_produtos();
		
		// importa a class imagens
		jimport('edesktop.programas.produtos.imagens');	

		// inicia no obj
		$img = new edesktop_produtos_imagens();
		

		// ID do produtos
		$id = JRequest::getvar('id', 0);		

		
		// busca os dados do produto
		$produto = $db->busca_por_id($id);
		
		
		// verifica o produto
		if(!$produto)
			die( 'Produto inválido' );
		
			
		// cria uma class de retorno
		$r = new stdClass();
		
		
		// adiciona o produto
		$r->db = $produto;
		
		
		// adiciona a imagem destaque
		$imagem = $img->busca_destaque_por_produto($produto->id);
		$r->db->imagem = $imagem->url;

		// cria uma class do carrinho
		$r->carrinho = new stdClass();


		// carrega as opções
		$r->carrinho->op = JRequest::getvar('op', array());	
		
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