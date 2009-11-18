<?php
// evitar acesso direto
defined('_JEXEC') or die('Acesso restrito');

class ebasicModel extends JModel
{
	var
		$_id,
		$_dados,
		$_queryListagem,
		$_queryCadastro;

	function __construct()
	{
	  parent::__construct();

	  $this->_campoTrashed   = "trashed";

	  $array = JRequest::getVar('cid',  0, '', 'array');
	  $this->_setId((int) $array[0]);
	}

	function _setId($id)
	{
		// Define id e limpa os dados
		$this->_id    = $id;
		$this->_dados = null;
	}


    function getListagem()
    {

		$where = "{$this->_campoTrashed} != '1'";
        $query = str_replace('%where%', $where, $this->_queryListagem);
		$this->_dados = $this->_getList($query);

        return $this->_dados;
    }

    function getLixeira()
    {
		$where = "{$this->_campoTrashed} = '1'";
        $query = str_replace('%where%', $where, $this->_queryListagem);
		$this->_dados = $this->_getList($query);

        return $this->_dados;
    }

	function getCadastro()
	{
		$where = "trashed != '1' AND id = '{$this->_id}'";
        $query = str_replace('%where%', $where, $this->_queryCadastro);

		// Carrega os dados
		$this->_db->setQuery($query);
		$this->_dados = $this->_db->loadObject();

		if (!$this->_dados) {
			$this->_dados = new stdClass();

			$this->_dados->id = 0;
			$this->_dados->published = 1;
		}

		return $this->_dados;
	}

	function salvar($dados = false)
	{
		$row =& $this->getTable();

		if(!$dados) $dados = JRequest::get('post');

		// Ligar campos do formulário com a tabela
		if (!$row->bind($dados)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Garantir que o registro é válido
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Armazenar a tabela na base de dados
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		$this->_setId($row->id);

		return true;
	}

	function deletar()
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$row =& $this->getTable();

		foreach($cids as $cid) {
			if (!$row->delete( $cid )) {
				$this->setError( $row->getErrorMsg() );
				return false;
			}
		}

		return true;
	}

	function publish($valor)
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$row =& $this->getTable();
		$row->publish($cids, $valor);
	}

	function trash($valor)
	{
		$cids = JRequest::getVar( 'cid', array(0), 'request', 'array' );
		$row =& $this->getTable();

		foreach($cids as $id)
		{
			$dados = array(
				'id' => $id,
				'trashed' => $valor
			);

			if (!$row->bind($dados))
				JError::raiseWarning( 500, $row->getError() );

			if (!$row->store())
				JError::raiseError(500, $row->getError() );

		}

	}


}
?>
