<?php
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.view');

class ecompVIEWcadastro extends JView
{
	function display($tpl = null)
	{
		global $mainframe;

		$params = $mainframe->getParams();
		$this->assignRef('params',	$params);

		parent::display($tpl);
	}
}
?>
