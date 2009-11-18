<?php
// evitar acesso direto
defined('_JEXEC') or die('Acesso restrito');

class ecompMODELcampos extends ebasicModel
{
	function __construct()
	{
		parent::__construct();
		
		$this->_queryListagem = "SELECT * ,(SELECT nome FROM ".ECOMP_TABLE_COMPONENTES." WHERE id = idcomponente) AS 'componente', (SELECT nome FROM ".ECOMP_TABLE_TIPOS." WHERE id = idtipo) AS 'tipo' FROM ".ECOMP_TABLE_CAMPOS." WHERE %where% ORDER BY componente, ordering ASC";
		$this->_queryCadastro = "SELECT * FROM #__ecomp_campos WHERE %where% ORDER BY nome ASC";
	}

	function salvar()
	{
		// chama o class util
		require_once(ECOMP_PATH_CLASS.DS.'ebasic.util.php');

		// se não existir um nome, retorma erro
		if(empty($_POST['nome'])) return false;

		// carrega do post para a var dados
		$dados = $_POST;

		// apaga variaveis inuteis
		unset($dados['option'], $dados['task'], $dados['view'], $dados['layout']);

		// abre a tabela de campos do ecomp
		$campo = new JCRUD(ECOMP_TABLE_CAMPOS, $dados);

		// abre a tabela de componentes
		$componente = new JCRUD(ECOMP_TABLE_COMPONENTES, array('id' => $campo->idcomponente));
		
		// abre a tabela de tipos
		$tipo = new JCRUD(ECOMP_TABLE_TIPOS, array('id' => $campo->idtipo));		

		// limpa o alias, caso não exista, gera um alias com o nome
		$campo->alias = eUtil::texto_limpo($campo->alias) ? eUtil::texto_limpo($campo->alias) : eUtil::texto_limpo($campo->nome);

		// se o id não existir, inseri!
		if(!$campo->id)
		{
			// cria um novo campo na tabela do componente
			JCRUD::query("ALTER TABLE `".ECOMP_TABLE_COMPONENTES."_{$componente->alias}` ADD `{$campo->alias}` {$tipo->code}");
			
			// inseri o registro
			$campo->insert();
			
			// retorna msg de ok para o usuário
			return true;
		}
		// atualiza o registro
		else
		{						
			// se o alias do campo mudou
			$r = $campo->busca_por_id($campo->id);
			if(($campo->alias != $r->alias) or ($campo->idtipo != $r->idtipo))
			{
				// altera o campo na tabela do componente
				JCRUD::query("ALTER TABLE `".ECOMP_TABLE_COMPONENTES."_{$componente->alias}` CHANGE `{$r->alias}` `{$campo->alias}` {$tipo->code}");
			} 
			
			// atualiza o registro
			$campo->update();
			
			// retorna msg de ok para o usuário
			return true;
		}
	}

	function deletar()
	{
		$cids = JRequest::getVar('cid', array(0), 'request', 'array');

		foreach($cids as $id)
		{
			// abre o compo da tabela do componente
			$campo = new JCRUD(ECOMP_TABLE_CAMPOS, array('id' => $id));
			
			// abre a tabela de componentes
			$componente = new JCRUD(ECOMP_TABLE_COMPONENTES, array('id' => $campo->idcomponente));

			// deleta a coluna do componente
			JCRUD::query("ALTER TABLE `".ECOMP_TABLE_COMPONENTES."_{$componente->alias}` DROP `{$campo->alias}`");

			// deleta o campo
			$campo->delete();
		}
		
		// retorna msg de ok para o usuário
		return true;
	}
	



//ALTER TABLE `jos_ecomp_campos` DROP `tit` 
}
?>
