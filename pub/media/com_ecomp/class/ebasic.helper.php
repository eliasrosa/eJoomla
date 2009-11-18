<?php
abstract class eHelper
{
	/**
	 * Busca uma categoria/tags ou todas categorias/tags filhas
	 *
	 * @param integer $idcomponente
	 * @param integer $idstart
	 * @param boolean $filhas
	 * @param string  [categorias | tags]
	 * @return array/object
	 */
	function busca_categorias_tags($idcomponente, $idstart = 0, $filhas = true, $tabela = 'categorias')
	{
		$tb = $tabela == 'categorias' ? ECOMP_TABLE_CATEGORIAS : ECOMP_TABLE_TAGS;

		$t = new JCRUD($tb);
		$array = $t->busca("WHERE idcomponente = '{$idcomponente}' AND id = '{$idstart}'");

		if($filhas)
		{
			$filhas = $t->busca("WHERE idcomponente = '{$idcomponente}' AND idpai = '{$idstart}'");
			foreach($filhas as $filha)
			{
				$f = eHelper::busca_categorias_tags($idcomponente, $filha->id, true, $tabela);
				$array  = array_merge($array, $f);
			}
		}

		return $array;
	}


	/**
	 * Retorna uma string de ids separados por ', ' dos registros
	 *
	 * @param integer $idcomponente
	 * @param integer $idstart
	 * @param boolean $filhas
	 * @param string  [categorias | tags]
	 * @return string
	 */
	function busca_registros_relacionados($idcomponente, $idstart = 0, $filhas = true, $tabela = 'categorias')
	{
		$ids = eHelper::busca_categorias_tags($idcomponente, $idstart,  $filhas, $tabela);
		$ids = eUtil::joinCampo($ids);

		if($tabela == 'categorias')
		{
			$tabela = ECOMP_TABLE_CADASTROS_CATEGORIAS;
			$campo  = 'idcategoria';
		}
		else
		{
			$tabela = ECOMP_TABLE_CADASTROS_TAGS;
			$campo  = 'tdtag';
		}

		$t = new JCRUD($tabela);
		$c = $t->busca("WHERE idcomponente = '{$idcomponente}' AND {$campo} IN ({$ids})");

		$r = count($c) ? eUtil::joinCampo($c, 'idcadastro') : '';

		return $r;
	}


	/**
	 * Busca o id da categoria/tag PAI
	 *
	 * @param integer $idcomponente
	 * @param integer $idstart
	 * @param boolean $tree
	 * @param string  [categorias | tags]
	 * @return object/JCRUD
	 */
	function busca_categorias_tags_pai($idcomponente, $idstart = 0, $tabela = 'categorias')
	{
		$tb = $tabela == 'categorias' ? ECOMP_TABLE_CATEGORIAS : ECOMP_TABLE_TAGS;

		$t = new JCRUD($tb);
		$a = $t->busca("WHERE idcomponente = '{$idcomponente}' AND id = '{$idstart}'");

		if($a->idpai != 0)
		{
			$tt = $t->busca("WHERE idcomponente = '{$idcomponente}' AND idpai = '{$idstart}'");
			foreach($tt as $tr)
			{
				$a = eHelper::busca_categorias_tags_pai($idcomponente, $tr->id, $tabela);
			}
		}

		return $a->id;
	}


	function monta_paginacao($tabela, $where, $porpagina = 1)
	{
		if (empty($tabela) || empty($where))
			return;

		// paginação
		$p = JRequest::getInt('p', 1);
		$inicio = $porpagina * ($p - 1);

		jimport('joomla.environment.uri');

		$u =& JURI::getInstance();

		// pega todos os registros
		$regs = $tabela->busca_por_sql("SELECT COUNT(*) AS total FROM @tabela@ WHERE {$where}");

		$pag_total = $regs[0]->total;
		$pag_num   = ceil($pag_total / $porpagina);

		$pag = '';

		for ($i = 1; $i <= $pag_num; $i++)
		{
			$u->setVar('p', $i);
			$class = $i == $p ? ' class="atual"' : '';
			$pag .= sprintf('<a href="%s"%s>%d</a>', $u->toString(), $class, $i);
		}

		return $pag;
	}


	/**
	 * Retorna o nome da tabela do componente
	 *
	 * @param integer $id
	 * @return string
	 */
	function componente_tabela_nome($id = 0)
	{
		$componente = new JCRUD(ECOMP_TABLE_COMPONENTES);
		$componente = $componente->busca_por_id($id);

		return ECOMP_TABLE_COMPONENTES . '_' . $componente->alias;
	}
}
?>
