<?php

// evitar acesso direto
defined( '_JEXEC' ) or die( 'Acesso restrito' );
 
jimport( 'joomla.application.component.view');
 
class edesktopVIEWprodutos extends JView
{
    function display($tpl = null)
    {
        $falaOla = "Olá pessoal!";
        $this->assignRef( 'saudacao', $falaOla );
 
        parent::display($tpl);
    }
}

?>