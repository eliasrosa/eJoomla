<?php

class JCRUD
{
	private $__tabela = "";
	private $__dados  = array();

	public function __construct($tabela, $campos = array())
	{
		$this->__tabela = $tabela;

		if(is_array($campos))
		{
			$this->__dados = $campos;

			if($this->id >= 1)
			{
				$r = $this->busca_por_id($this->id);
				$this->__dados = array_merge($r->get_dados(), $campos);
			}
		}
	}

	public function busca_por_sql($q)
	{
		if (!$this->verifica_tabela())
			return false;

		$q = str_replace('@tabela@', $this->__tabela, $q);

		$db =& JFactory::getDBO();

		$db->setQuery($q);

		if (!$db->query() && $db->getErrorNum())
		{
			echo "Erro mysql {$db->getErrorNum()} - {$db->getErrorMsg()}";
			return false;
		}

		$objetos = array();

		foreach ($db->loadObjectList() as $l)
		{
			$objetos[] = $this->instanciar($l);
		}

		return $objetos;
	}

	public function query($q)
	{
		$db =& JFactory::getDBO();

		$q = str_replace('@tabela@', $this->__tabela, $q);

		$db->setQuery($q);

		if (!$db->query() && $db->getErrorNum())
		{
			echo "Erro mysql {$db->getErrorNum()} - {$db->getErrorMsg()}";
			return false;
		}

		return $db;
	}


	function paginacao($where, $porpagina = 1, $urlbase = null, $getVar = 'pag' )
	{

		// retorno
		$retorno = new stdClass();

		if (empty($where))
			return $retorno;

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
		$regs = $this->busca_por_sql("SELECT COUNT(*) AS total FROM @tabela@ {$where}");

		// pega o total de registros encontrados
		$registros = $regs[0]->total;
		
		// calcula o total de páginas
		$paginas = ceil($registros / $porpagina);
		
		// total
		$retorno->registros = $registros;
		
		// mysql limit
		$retorno->limit = "{$inicio}, {$porpagina}";		
		$retorno->inicio = $inicio;		
		$retorno->porpagina = $porpagina;
		
		// total de páginas
		$retorno->paginas = $paginas;
				
		// páginas
		$retorno->links = '';
		
		// loop nas páginas
		for ($i = 1; $i <= $paginas; $i++)
		{
			// adiciona a var na url
			$u->setVar($getVar, $i);
			
			// adicion a class 'atual' na página ativa
			$class = $i == $p ? ' class="atual"' : '';
			
			// retorna o html das p
			$retorno->links .= sprintf('<a href="%s"%s>%d</a>', JRoute::_($u->toString()), $class, $i);
		}

		return $retorno;
	}


	public function busca_tudo($order = "")
	{
		if (!empty($order))
			$order = " ORDER BY {$order}";

		return $this->busca_por_sql("SELECT * FROM {$this->__tabela}$order");
	}

	public function busca($sql = "")
	{
		$sql = "SELECT * FROM @tabela@ {$sql}";
		$r = $this->busca_por_sql($sql);
		return $r;
	}

	public function num_registros($q = "")
	{
		if (!$this->verifica_tabela())
			return false;

		$db =& JFactory::getDBO();

		if (empty($q))
			$q = "SELECT COUNT(*) FROM {$this->__tabela}";

		$db->setQuery($q);

		$l = $db->loadAssoc();

		return array_shift($l);
	}

	public function delete($id = 0, $campo = 'id', $limit = 1)
	{
		if (!$this->verifica_tabela())
			return false;

		$id = (int) $id;

		$id = !$id ? $this->id : $id;
		
		$limit = $limit ? 'LIMIT '.$limit : '';

		$q = "DELETE FROM {$this->__tabela} WHERE {$campo} = '{$id}' {$limit}";

		$db =& JFactory::getDBO();
		$db->setQuery($q);

		if (!$db->query() && $db->getErrorNum())
		{
			echo "Erro mysql {$db->getErrorNum()} - {$db->getErrorMsg()}";
			return false;
		}

		return $db->getAffectedRows() == 1 ? true : false;
	}

	public function insert($useID = true)
	{
		if (!$this->verifica_tabela())
			return false;

		$db =& JFactory::getDBO();

		$campos = array_merge($this->__dados);
		$campos = $this->instanciar($campos, 'stdClass');
		
		if($useID === false)
			unset($campos->id);
			
		if ($db->insertObject($this->__tabela, $campos))
		{
			if($useID === true)
				$this->id = $db->insertid();
				
			return true;
		}

		if ($db->getErrorNum())
			echo "Erro mysql {$db->getErrorNum()} - {$db->getErrorMsg()}";

		return false;
	}

	public function update($campo = 'id')
	{
		$db =& JFactory::getDBO();

		$campos = array_merge($this->__dados);
		$campos = $this->instanciar($campos, 'stdClass');

		if ($db->updateObject($this->__tabela, $campos, $campo))
			return true;

		if ($db->getErrorNum())
			echo "Erro mysql {$db->getErrorNum()} - {$db->getErrorMsg()}";

		return false;
	}

	public function busca_por_id($id = 0, $campo = 'id')
	{
		if (!$this->verifica_tabela())
			return false;

		$sql = "SELECT * FROM @tabela@ WHERE {$campo} = '{$id}'";
		$r = $this->busca_por_sql($sql);

		return !empty($r) ? array_shift($r) : false;
	}

	private function instanciar($l, $class = 'JCRUD')
	{
		$objeto = new $class($this->__tabela);

		foreach ($l as $nome => $valor)
		{
			$nome = strtolower($nome);
			$objeto->$nome = $valor;
		}

		return $objeto;
	}

	public function __set($nome, $valor)
	{
		$this->__dados[$nome] = $valor;
	}

	public function __get($nome)
	{
		$nome = strtolower($nome);
		return @$this->__dados[$nome];
	}

	public function get_dados()
	{
		return $this->__dados;
	}

	private function verifica_tabela()
	{
		if (isset($this->__tabela))
			return true;
		else
		{
			echo "Erro: Tabela não especificada";
			return false;
		}
	}
}

?>
