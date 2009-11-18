<?php
// evitar acesso direto
defined( '_JEXEC' ) or die( 'Acesso restrito' );

class ecompCONTROLLERcadastros extends ebasicController
{

	function _redirect($msg = null, $task = false)
	{
		$task = !$task ? '' : "&task={$task}";	
		
		$idcomponente = JRequest::getVar('idcomponente', 0);
				
		//link do redirecionamento
		$link = "index.php?option={$this->eBasic->option}&view={$this->eBasic->view}&idcomponente={$idcomponente}{$task}";
		$this->setRedirect($link, $msg);
	}

}
?>
