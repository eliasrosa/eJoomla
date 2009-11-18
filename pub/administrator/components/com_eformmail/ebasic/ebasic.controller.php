<?php
// evitar acesso direto
defined( '_JEXEC' ) or die( 'Acesso restrito' );

class ebasicController extends JController
{
	var $eBasic,
		$modelo;

	function __construct()
	{
		parent::__construct();

		// abre o eBasic
		$this->eBasic =& new eBasic();

		// carrega o modelo
		$this->modelo =& $this->getModel($this->eBasic->view);

		// Registrar tarefas extras
		$this->registerTask('add', 'cadastro');
		$this->registerTask('edit', 'cadastro');

	}

	function _redirect($msg = null, $task = false)
	{
		$task = !$task ? '' : "&task={$task}";
		
		//link do redirecionamento
		$link = "index.php?option={$this->eBasic->option}&view={$this->eBasic->view}{$task}";
		$this->setRedirect($link, $msg);
	}

	function cadastro()
	{
		// carrega o layou de cadastro
		JRequest::setVar( 'layout', 'cadastro');

		parent::display();
	}

	function listTrash()
	{
		// carrega o layou de lixeira
		JRequest::setVar( 'layout', 'lixeira');

		parent::display();
	}

	function save()
	{
		if($this->modelo->salvar())
			$msg = JText::_('Registro salvo com sucesso!');
		else
			$msg = JText::_('Erro: Ao salvar o registro.');

		// Redirecionar
		$this->_redirect($msg);
	}

	function remove()
	{
		if(!$this->modelo->deletar())
			$msg = JText::_('Erro: Um ou mais regitros não poderam ser removidos');
		else
			$msg = JText::_('Registro(s) removido(s)');

		// Redirecionar
		$this->_redirect($msg, 'listTrash');
	}

	function unTrash()
	{
		$this->modelo->trash(0);
		
		// Redirecionar
		$this->_redirect('O(s) registro(s) restaurado(s)', 'listTrash');
	}
	
	function moveTrash()
	{
		$this->modelo->trash(1);
		
		// Redirecionar
		$this->_redirect('O(s) registro(s) movido(s) para a lixeira');
	}

	function cancel()
	{
		// Redirecionar
		$this->_redirect('Operação cancelada!');
	}

	function publish()
	{
		$this->modelo->publish(1);

		// Redirecionar
		$this->_redirect('Registro(s) publicado(s) com sucesso!');
	}

	function unpublish()
	{
		$this->modelo->publish(0);

		// Redirecionar
		$this->_redirect('Registro(s) despublicado(s) com sucesso!');
	}
}
?>