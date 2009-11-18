<?php
// evitar acesso direto
defined('_JEXEC') or die('Acesso restrito');

class ecompVIEWimagens extends eBasicView
{
	function __construct()
	{
		$componente = new JCRUD(ECOMP_TABLE_COMPONENTES, array( 'id' => JRequest::getVar('idcomponente', 0)));
		$this->comTitulo = "Administrar {$componente->nome} - <small>Imagens</small>";

		parent::__construct();
	}

}
?>
