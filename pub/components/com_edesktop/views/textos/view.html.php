<?php

// evitar acesso direto
defined( '_JEXEC' ) or die( 'Acesso restrito' );
 
jimport( 'joomla.application.component.view');
 
class edesktopVIEWtextos extends JView
{
    function display($tpl = null)
    {
		// carega o menu		
		$menu =& JSite::getMenu();
		
		// carrega parâmetros do menu
		$menuItem =& $menu->getActive();	
		$this->assignRef('menu', $menuItem);
		
		// carrega parâmetros
		$params = $menu->getParams($menuItem->id);		
		$this->assignRef('params', $params);


		$app =& JFactory::getApplication();
		$templateDir = JPATH_THEMES .DS. $app->getTemplate();
		
		
		
		
		$this->assignRef('template', $templateDir);
	
        parent::display($tpl);
    }
}

?>