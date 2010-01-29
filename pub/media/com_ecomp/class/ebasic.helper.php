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


	function monta_paginacao($tabela, $where, $porpagina = 1, $urlbase = null, $getVar = 'pag' )
	{
		if (empty($tabela) || empty($where))
			return;

		// retorno
		$retorno = array();

		// pega a pagina atual
		$p = JRequest::getInt($getVar, 1);
		
		// calcula a linha do registro de inicio
		$inicio = $porpagina * ($p - 1);

		// adiciona a biblioteca juri
		jimport('joomla.environment.uri');

		// verifica se a urlbase foi adicionada
		if(!is_null($urlbase))
			$u =& JURI::getInstance($urlbase);
		
		// caso contrário usa a urel atual
		else
			$u =& JURI::getInstance();

		// pega todos os registros
		$regs = $tabela->busca_por_sql("SELECT COUNT(*) AS total FROM @tabela@ WHERE {$where}");

		// pega o total de registros encontrados
		$pag_total = $regs[0]->total;
		
		// calcula o total de páginas
		$pag_num   = ceil($pag_total / $porpagina);
		
		// total
		$retorno['total_registros'] = $pag_total;
		
		// mysql limit
		$retorno['mysql_limit'] = "{$inicio}, {$porpagina}";		
		$retorno['mysql_limit_inicio'] = $inicio;		
		$retorno['mysql_limit_porpaginas'] = $porpagina;
		
		// total de páginas
		$retorno['paginas_total'] = $pag_num;
				
		// páginas
		$retorno['paginas_html'] = '';
		
		// loop nas páginas
		for ($i = 1; $i <= $pag_num; $i++)
		{
			// adiciona a var na url
			$u->setVar($getVar, $i);
			
			// adicion a class 'atual' na página ativa
			$class = $i == $p ? ' class="atual"' : '';
			
			// retorna o html das p
			$retorno['paginas_html'] .= sprintf('<a href="%s"%s>%d</a>', JRoute::_($u->toString()), $class, $i);
		}

		return $retorno;
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
		
		if(empty($componente->alias))
			return ECOMP_TABLE_COMPONENTES . '_' . $componente->alias;
		else
			JError::raiseError(404, 'Componente não encontrado!');
	}

	
	/**
	 * Altera temporariamente o parametro do eLoad responsavel pelo titulo
	 *
	 * @param string $titulo
	 * @return void
	 */
	function setTitle($titulo)
	{
		$_SESSION['eload']['title'] = $titulo;		
	}


	/**
	 * Altera a META TAG description
	 *
	 * @param string $description
	 * @param string $limit
	 * @return void
	 */
	function setDescription($description, $limit = 160)
	{
		$doc =& JFactory::getDocument();
		$description = substr(strip_tags($description), 0, $limit);
		$doc->setMetaData( 'description', $description );	
	}


	/**
	 * Altera a META TAG keywords
	 *
	 * @param string $keywords
	 * @return void
	 */
	function setKeywords($keywords)
	{
		$doc =& JFactory::getDocument();
		$doc->setMetaData('keywords', $keywords);
	}
	
}
?>
