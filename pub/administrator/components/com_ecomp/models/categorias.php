<?php
// evitar acesso direto
defined('_JEXEC') or die('Acesso restrito');

class ecompMODELcategorias extends ebasicModel
{
	function __construct()
	{
		parent::__construct();

		$idcomponente = JRequest::getVar('idcomponente');
		$this->_queryListagem = "SELECT * FROM ".ECOMP_TABLE_CATEGORIAS." WHERE idcomponente = {$idcomponente} AND %where% ORDER BY ordering ASC, nome ASC";
		$this->_queryCadastro = "SELECT * FROM ".ECOMP_TABLE_CATEGORIAS." WHERE idcomponente = {$idcomponente} AND %where% ORDER BY ordering ASC, nome ASC";
	}

    function salvar()
    {
		// chama o class util
		require_once(ECOMP_PATH_CLASS.DS.'ebasic.util.php');

		$dados = JRequest::get('post');
		$dados['alias'] = eUtil::texto_limpo($dados['alias'], true) ? eUtil::texto_limpo($dados['alias'], true) : eUtil::texto_limpo($dados['nome'], true);

		return parent::salvar($dados);
    }

    function deletar()
    {
		$cids = JRequest::getVar('cid', array(0), 'request', 'array');

		foreach($cids as $id)
		{
			// abre o compo da tabela
			$registro = new JCRUD(ECOMP_TABLE_CATEGORIAS, array('id' => $id));

			// abre a tabela de relacionamentos
			$relacionamentos = new JCRUD(ECOMP_TABLE_CADASTROS_CATEGORIAS);
			$relacionamentos = $relacionamentos->busca("WHERE idcategoria = {$id}");
			foreach($relacionamentos as $relacionamento )
			{
				$relacionamento->delete();
			}

			// deleta o campo
			$registro->delete();
		}

		// retorna msg de ok para o usuário
		return true;
    }

    function getListagem()
    {
		return $this->getTree(0);
    }

	function getTree($id)
	{
		$where = "trashed != '1' AND idpai = '$id'";
        $query = str_replace('%where%', $where, $this->_queryListagem);

		$dados   = $this->_getList($query);

		$r = array();
		foreach($dados as $a)
		{
			$r[] = $a;

			$filhos = $this->getTree($a->id);
			if(count($filhos))
				$r[] = $filhos;
		}

		return $r;
	}

}
?>
