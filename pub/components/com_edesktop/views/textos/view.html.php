<?php

// evitar acesso direto
defined( '_JEXEC' ) or die( 'Acesso restrito' );
 
jimport( 'joomla.application.component.view');
 
class edesktopVIEWtextos extends JView
{
    function display($tpl = null)
    { 
        parent::display($tpl);
    }
}

?>