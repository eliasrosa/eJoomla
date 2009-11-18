<?php
// evitar acesso direto
defined('_JEXEC') or die('Acesso restrito');

class eBasic
{
	public
		$option,
		$layout,
		$task,
		$view,
		$com;

	public function __construct()
	{
		$this->option = JRequest::getVar('option');
		$this->task   = JRequest::getVar('task');
		$this->com    = substr($this->option, 4);
		$this->view   = JRequest::getVar('view') ? JRequest::getVar('view') : $this->com;

		// seta a listagem com layout padrao
		$this->layout = JRequest::getVar('layout') ? JRequest::getVar('layout') : 'listagem';
		JRequest::setVar('layout', $this->layout);

		//
		jimport('joomla.application.component.model');
		jimport('joomla.application.component.controller');
		jimport('joomla.application.component.view');

		// carrega o controlador padrão
		require_once('ebasic.controller.php');

		// carrega o view padrão
		require_once('ebasic.view.php');

		// carrega o model padrão
		require_once('ebasic.model.php');

	}

	public function componentStart()
	{
		if($this->view)
		{
			// carrega o controlador filho se existir
			$controller = JPATH_COMPONENT.DS.'controllers'.DS.$this->view.'.php';
			if(file_exists($controller))
			{
				require_once(JPATH_COMPONENT.DS.'controllers'.DS.$this->view.'.php' );
				$controller = $this->view;
			}
			else
			{
				$controller = '';
			}

			// Cria o controle
			$classname  = "{$this->com}CONTROLLER{$controller}";
			$controller = new $classname();

			// se existir o task, executa o controller
			$controller->execute($this->task);

			// redireciona
			$controller->redirect();
		}
	}
}
?>