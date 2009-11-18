<?php
// evitar acesso direto
defined('_JEXEC') or die('Acesso restrito');

class EformmailModelEformmail extends ebasicModel
{
	function __construct()
	{
		parent::__construct();

		$this->_queryListagem = "SELECT * FROM #__eformmail_formularios WHERE %where%";
		$this->_queryCadastro = "SELECT * FROM #__eformmail_formularios WHERE %where%";
	}


	function salvar()
	{
		return parent::salvar($_POST);
	}

}
?>
