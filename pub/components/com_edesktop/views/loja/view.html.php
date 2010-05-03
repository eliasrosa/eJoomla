<?php

// evitar acesso direto
defined( '_JEXEC' ) or die( 'Acesso restrito' );
 
jimport( 'joomla.application.component.view');
 
class edesktopVIEWloja extends JView
{
    function display($tpl = null)
    { 
		// adiciona o style css da loja
		JHTML::stylesheet('style.css', 'media/com_edesktop/loja/css/');
				
		$menu =& JSite::getMenu();
		
		// carrega parâmetros
		$item =& $menu->getActive();	
		$this->assignRef('menu', $item);
		
		// carrega parâmetros
		$params = $menu->getParams($item->id);		
		$this->assignRef('params', $params);
		
		// carrega parâmetros do menu da loja
		$itemid = JRequest::getvar('Itemid');
		$menu =& JSite::getMenu();
		$item =& $menu->getItem($itemid);
		$params = $menu->getParams($item->id);
		$itemid = ($params->get('Itemid')) ? $params->get('Itemid') : $itemid;
		$this->assignRef('itemid', $itemid);		
		
		// carrega o layout
		$layout = JRequest::getvar('layout');
		
		// produtos por pagina
		$this->porpagina = 2;
		
		$funcao = "layout_$layout";
		
		if(file_exists(dirname(__FILE__) .DS. 'tmpl' .DS. $layout .'.php'))
			$this->$funcao();
		
		// carrega o template
        parent::display($tpl);
	
	}
	
	
	
	/*
	 ************************************************/		
	private function layout_destaques()
	{
		// importa a class produtos
		jimport('edesktop.programas.produtos.produtos');

		// inicia no obj
		$db = new edesktop_produtos_produtos();
		
		// paginação
		$db->paginacao = $this->porpagina;
		
		// busca dados
		$dados = $db->busca_por_destaque();

		// envia para o layout os dados
		$this->assignRef('dados', $dados);
		
		// envia para o layout a paginação
		$this->assignRef('paginacao', $db->paginacao);	
	}




	// carrega dados do layout destaques
	private function layout_fabricante()
	{
		// importa a class produtos
		jimport('edesktop.programas.produtos.produtos');

		// inicia no obj
		$db = new edesktop_produtos_produtos();

		// paginação
		$db->paginacao = $this->porpagina;
		
		// carrega o id
		$id = JRequest::getvar('id', 0);
		
		// busca dados
		$dados = $db->busca_por_fabricante($id);

		// envia para o layout
		$this->assignRef('dados', $dados);
		
		// envia para o layout a paginação
		$this->assignRef('paginacao', $db->paginacao);	
	}




	// carrega dados do layout categoria
	private function layout_categoria()
	{
		// importa a class produtos
		jimport('edesktop.programas.produtos.produtos');
		
		// importa a class de categorias de produtos
		jimport('edesktop.programas.produtos.categorias');

		// inicia o obj
		$db = new edesktop_produtos_produtos();
		$cat = new edesktop_produtos_categorias();
		
		// paginação
		$db->paginacao = $this->porpagina;
		
		// carrega o id ca categoria
		$id = JRequest::getvar('id', 0);
		
		// carrega ids das categorias filhas
		$ids = $cat->busca_ids($id);
		
		// busca dados
		$dados = $db->busca_por_categorias($ids);

		// envia para o layout
		$this->assignRef('dados', $dados);
		
		// envia para o layout a paginação
		$this->assignRef('paginacao', $db->paginacao);
	}




	private function layout_busca()
	{
		// importa a class produtos
		jimport('edesktop.programas.produtos.produtos');

		// inicia no obj
		$db = new edesktop_produtos_produtos();
		
		// paginação
		$db->paginacao = $this->porpagina;
		
		// carrega o busca
		$busca = JRequest::getvar('q', '');
		
		// busca dados
		$dados = $db->busca_por_texto($busca);

		// envia para o layout
		$this->assignRef('dados', $dados);
		
		// envia para o layout a paginação
		$this->assignRef('paginacao', $db->paginacao);
	}
		
		
		
}

?>