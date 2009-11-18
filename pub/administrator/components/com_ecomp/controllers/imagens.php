<?php
// evitar acesso direto
defined( '_JEXEC' ) or die( 'Acesso restrito' );

class ecompCONTROLLERimagens extends ebasicController
{
	function _redirect($msg = null, $task = false)
	{
		$task = !$task ? '' : "&task={$task}";

		$idcomponente = JRequest::getVar('idcomponente', 0);
		$idcadastro   = JRequest::getVar('idcadastro', 0);

		//link do redirecionamento
		$link = "index.php?option={$this->eBasic->option}&view={$this->eBasic->view}&idcomponente={$idcomponente}&idcadastro={$idcadastro}{$task}";
		$this->setRedirect($link, $msg);
	}
}
?>
