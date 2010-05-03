<?php

// evitar acesso direto
defined( '_JEXEC' ) or die( 'Acesso restrito' );
 
jimport( 'joomla.application.component.view');
 
class edesktopVIEWloja extends JView
{
    function display($tpl = null)
    { 
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
		
		// carrega dados do layout destaques
		if($layout == 'destaques')
		{
			// importa a class produtos
			jimport('edesktop.programas.produtos.produtos');

			// inicia no obj
			$dados = new edesktop_produtos_produtos();
			
			// busca dados
			$dados = $dados->busca_por_destaque();

			// envia para o layout
			$this->assignRef('dados', $dados);
		}




		// carrega dados do layout destaques
		elseif($layout == 'fabricante')
		{
			// importa a class produtos
			jimport('edesktop.programas.produtos.produtos');

			// inicia no obj
			$dados = new edesktop_produtos_produtos();
			
			// carrega o id
			$id = JRequest::getvar('id', 0);
			
			// busca dados
			$dados = $dados->busca_por_fabricante($id);

			// envia para o layout
			$this->assignRef('dados', $dados);
		}




		// carrega dados do layout categoria
		elseif($layout == 'categoria')
		{
			// importa a class produtos
			jimport('edesktop.programas.produtos.produtos');
			jimport('edesktop.programas.produtos.categorias');

			// inicia no obj
			$dados = new edesktop_produtos_produtos();
			$cat = new edesktop_produtos_categorias();
			
			// carrega o id
			$id = JRequest::getvar('id', 0);
			
			// carrega ids das categorias filhas
			$ids = $cat->busca_ids($id);
			
			// busca dados
			$dados = $dados->busca_por_categorias($ids);

			// envia para o layout
			$this->assignRef('dados', $dados);
		}




		// carrega dados do layout busca
		elseif($layout == 'busca')
		{
			// importa a class produtos
			jimport('edesktop.programas.produtos.produtos');

			// inicia no obj
			$dados = new edesktop_produtos_produtos();
			
			// carrega o busca
			$busca = JRequest::getvar('q', '');
			
			// busca dados
			$dados = $dados->busca_por_texto($busca);

			// envia para o layout
			$this->assignRef('dados', $dados);
		}
		
		
		
		// carrega o template
        parent::display($tpl);
    }
}

?>