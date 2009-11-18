<?
class manager_menu
{
	function exibir()
	{
		$u =& JURI::getInstance();
		$t = new JCRUD(ECOMP_TABLE_COMPONENTES);
		$componentes = $t->busca("WHERE exibir_manager = '1' ORDER BY nome ASC");

		$query = array(
			'Itemid' => JRequest::getVar('Itemid'),
			'funcao' => 'listar',
			'idcomponente' => 0
		);

		// home
		echo sprintf('<a href="?%s">Home</a>',
			$u->buildQuery($query)
		);


		// componentes
		foreach($componentes as $c)
		{
			$query['idcomponente'] = $c->id;

			echo sprintf('<a href="?%s">%s</a>',
				$u->buildQuery($query),
				$c->nome
			);
		}


		// sair
		$query['funcao'] = 'sair';
		unset($query['idcomponente']);
		echo sprintf('<a href="?%s" class="sair">Sair</a>',
			$u->buildQuery($query)
		);
	}
}
?>
