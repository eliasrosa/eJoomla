<?php
// evitar acesso direto
defined('_JEXEC') or die('Acesso restrito');

class ecompListas
{
	function getTree($tabela, $idcomponente = 0, $idPai = 0, $where = '')
	{
		$tb = new JCRUD($tabela);
		$dados = $tb->busca("WHERE idpai='{$idPai}' AND idcomponente = '$idcomponente' {$where} ORDER BY ordering ASC, nome ASC");

		$r = array();
		foreach($dados as $a)
		{
			$r[] = $a;

			$filhos = $this->getTree($tabela, $idcomponente, $a->id, $where);
			if(count($filhos))
				$r[] = $filhos;
		}

		return $r;

	}

	function getLista($array, $dados, $nivel = 0, $name = '', $multiple = true)
	{
		$html   = '';
		$espace = '';
		$pai    = false;

		for($i=0; $i < $nivel; $i++ )
			$espace = $espace . '&nbsp;&nbsp;&nbsp;&nbsp;';

		if($multiple)
		{
			if(!$nivel)
				$html  = '<select multiple="multiple" size="10" name="'.$name.'[]">';
		}
		else
		{
			if(!$nivel)
				$html  = '<select size="10" name="'.$name.'">';

			if(!count($array))
				$html .= "<option value=\"0\">--- Categoria Pai ---</option>";
		}

		foreach($array as $row)
		{
			if(is_array($row))
				$html .= $this->getLista($row, $dados, $nivel + 1, $name, $multiple);
			else
			{
				if($multiple)
					$check = isset($dados[$row->id]) ? ' selected="selected"' : '';
				else
				{
					if(!$nivel && !$pai)
					{
						$check = $dados == '0' ? ' selected="selected"' : '';
						$html .= "<option value=\"0\"{$check}>--- Categoria Pai ---</option>";
						$pai   = true;
					}

					$check = $dados == $row->id ? ' selected="selected"' : '';
				}
				$html .= "<option value=\"{$row->id}\"{$check}>{$espace}{$row->nome}</option>";
			}
		}

		if(!$nivel)
			$html .= '</select>';

		return $html;
	}

	function getListaCategorias($id)
	{
		$idcomponente = JRequest::getVar('idcomponente', 0);

		$rel   = new JCRUD(ECOMP_TABLE_CADASTROS_CATEGORIAS);
		$rel   = $rel->busca("WHERE idcadastro = '$id'");
		$dados = array();
		foreach($rel as $r)
			$dados[$r->idcategoria] = $r->idcategoria;

		$categorias = $this->getTree(ECOMP_TABLE_CATEGORIAS, $idcomponente);
		echo $this->getLista($categorias, $dados, 0, 'categorias');
	}

	function getListaTags($id)
	{
		$idcomponente = JRequest::getVar('idcomponente', 0);

		$rel   = new JCRUD(ECOMP_TABLE_CADASTROS_TAGS);
		$rel   = $rel->busca("WHERE idcadastro = '$id'");
		$dados = array();
		foreach($rel as $r)
			$dados[$r->idtag] = $r->idtag;

		$tags = $this->getTree(ECOMP_TABLE_TAGS, $idcomponente);
		echo $this->getLista($tags, $dados, 0, 'tags');
	}

	function getListaCategoriasPai($id, $idpai)
	{
		$idcomponente = JRequest::getVar('idcomponente', 0);

		$where = $id > 0 ? "AND id != '{$id}'" : '';

		$categorias = $this->getTree(ECOMP_TABLE_CATEGORIAS, $idcomponente, 0, $where);
		echo $this->getLista($categorias, $idpai, 0, 'idpai', false);
	}

	function getListaTagsPai($id, $idpai)
	{
		$idcomponente = JRequest::getVar('idcomponente', 0);
		
		$where = $id > 0 ? "AND id != '{$id}'" : '';

		$tags = $this->getTree(ECOMP_TABLE_TAGS, $idcomponente, 0, $where);
		echo $this->getLista($tags, $idpai, 0, 'idpai', false);
	}
}
?>
