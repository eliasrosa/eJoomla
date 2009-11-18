<?php
defined('_JEXEC') or die( "Acesso Restrito" );
jimport('joomla.event.plugin');

class PLGSYSTEMeformmail extends JPlugin
{
	var $_html,
		$_resultado,
		$_resultado_total;

	function onAfterRender()
	{
		// ser for admin
		global $mainframe;
		if ($mainframe->isAdmin()) return;

		// pega o html
		$this->_html = JResponse::getBody();

		// verifica se existe algum formulário
		$this->busca_forms();

		// atualiza o html
		JResponse::setBody($this->_html);

		return;
	}

	private function busca_forms()
	{
		$exp = '#\[eFormMail \"(.+?)\"\]#';
		preg_match_all($exp, $this->_html, $this->_resultado);

		$this->_resultado_total = count($this->_resultado[0]);

		if($this->_resultado_total)
		{
			$this->cria_forms();
			$this->adiciona_scripts();
		}
	}


   private function cria_forms()
   {
		// abre a class createForm
		require_once(JPATH_BASE.DS.'media'.DS.'com_eformmail'.DS.'class'.DS.'createForm.class.php');

		for($i=0;$i<=$this->_resultado_total-1;$i++)
		{
			$code  = $this->_resultado[0][$i];
			$id    = $this->_resultado[1][$i];

			$db    =& JFactory::getDBO();
			$query = "SELECT * FROM #__eformmail_formularios WHERE id = '{$id}' AND published = '1' AND trashed != '1'";
			$dados = $db->setQuery($query);
			$dados = $db->loadObject();

			$form = new createForm(@$dados->form);
			$form = $form->ini(@$dados->id);

			$this->_html = str_replace($code, $form, $this->_html);

		}
		return;
	}

   private function adiciona_scripts()
   {
		$path = JURI::base() .'media/com_eformmail/';

		$head  = '<script type="text/javascript" src="'.$path.'js/jquery.meio.mask.min.js"></script>'."\n";
		$head .= '<script type="text/javascript" src="'.$path.'js/jquery.datepicker.js"></script>'."\n";
		$head .= '<script type="text/javascript" src="'.$path.'js/jquery.validaform-1.0.13.js"></script>'."\n";
		$head .= '<link rel="stylesheet" type="text/css" href="'.$path.'css/jquery.datepicker.css" />'."\n";
		$head .= '<script type="text/javascript">$(function(){ $("form.eFormMail").validaForm({ success: function(m){ alert(m); }, upload: true }); });</script>'."\n";
		$head .= '</head>'."\n";

		$this->_html = str_replace('</head>', $head, $this->_html);

		return;
	}
}
?>
