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

		$db->setQuery($q);

		if (!$db->query() && $db->getErrorNum())
		{
			echo "Erro mysql {$db->getErrorNum()} - {$db->getErrorMsg()}";
			return false;
		}

		return $db;
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

		$q = "DELETE FROM {$this->__tabela} WHERE {$campo} = '{$id}' LIMIT {$limit}";

		$db =& JFactory::getDBO();
		$db->setQuery($q);

		if (!$db->query() && $db->getErrorNum())
		{
			echo "Erro mysql {$db->getErrorNum()} - {$db->getErrorMsg()}";
			return false;
		}

		return $db->getAffectedRows() == 1 ? true : false;
	}

	public function insert()
	{
		if (!$this->verifica_tabela())
			return false;

		$db =& JFactory::getDBO();

		$campos = array_merge($this->__dados);
		$campos = $this->instanciar($campos, 'stdClass');

		if ($db->insertObject($this->__tabela, $campos))
		{
			$this->id = $db->insertid();
			return true;
		}

		if ($db->getErrorNum())
			echo "Erro mysql {$db->getErrorNum()} - {$db->getErrorMsg()}";

		return false;
	}

	public function update()
	{
		$db =& JFactory::getDBO();

		$campos = array_merge($this->__dados);
		$campos = $this->instanciar($campos, 'stdClass');

		if ($db->updateObject($this->__tabela, $campos, 'id'))
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
