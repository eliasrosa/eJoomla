<?php
// evitar acesso direto
defined('_JEXEC') or die('Acesso restrito');

class ecompMODELcomponentes extends ebasicModel
{
	function __construct()
	{
		parent::__construct();

		$this->_queryListagem = "SELECT * FROM ".ECOMP_TABLE_COMPONENTES." WHERE %where% ORDER BY nome ASC";
		$this->_queryCadastro = "SELECT * FROM ".ECOMP_TABLE_COMPONENTES." WHERE %where% ORDER BY nome ASC";
	}

	private function existe_tabela($tabela, $id = 0)
	{
		// verifica se a tabela ja existe
		$db = JCRUD::query("SHOW TABLES LIKE '".ECOMP_TABLE_COMPONENTES."_{$tabela}'");
		if(count($db->loadObject()))
			return true;
		else
			return false;
	}

	function salvar()
	{
		// chama o class util
		require_once(ECOMP_PATH_CLASS.DS.'ebasic.util.php');

		// abre o banco
		$db = & JFactory::getDBO();

		// se não existir um nome, retorma erro
		if(empty($_POST['nome'])) return false;

		// carrega do post para a var dados
		$dados = $_POST;

		// apaga variaveis inuteis
		unset($dados['option'], $dados['task'], $dados['view'], $dados['layout']);

		// captura o nome da nova tabela
		$tabela_nova = eUtil::texto_limpo($dados['nome']);

		// abre a tabela de componentes do ecomp
		$componente = new JCRUD(ECOMP_TABLE_COMPONENTES, $dados);

		// abre a tabela de menu/componentes
		$menu = new JCRUD(ECOMP_TABLE_JCOMPONENTS);

		// se o id não existir, inseri!
		if(!$componente->id)
		{
			// verifica se a tabela ja existe
			if($this->existe_tabela($tabela_nova))
				return false;

			// cria a nova tabela
			JCRUD::query("
				CREATE TABLE IF NOT EXISTS ".ECOMP_TABLE_COMPONENTES."_{$tabela_nova}(
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `published` int(11) NOT NULL DEFAULT '1',
				  `ordering` int(11) NOT NULL DEFAULT '0',
				  `trashed` int(11) NOT NULL DEFAULT '0',
				  `view_item` int(11) NOT NULL DEFAULT '0',
				  `view_lista` int(11) NOT NULL DEFAULT '0',
				  `view_busca` int(11) NOT NULL DEFAULT '0',
				  PRIMARY KEY (`id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1;
			");

			// inseri o registro
			if($componente->insert())
			{
				// busca o id do menu ecomp
				$ecomp_menu = $menu->busca_por_sql("SELECT * FROM @tabela@ WHERE name = 'eComp' AND admin_menu_alt = 'eComp'");

				// cadastra um novo menu
				$menu->enabled         = 1;
				$menu->admin_menu_link = "option=com_ecomp&view=cadastros&idcomponente={$componente->id}";
				$menu->parent          = $ecomp_menu[0]->id;
				$menu->ordering        = -1;
				$menu->iscore          = 1;
				$menu->name            = $componente->nome;
				$menu->admin_menu_alt  = $componente->nome;

				$menu->insert();

				$componente->idmenuadmin = $menu->id;
				$componente->alias = $tabela_nova;
				$componente->update();

				return true;
			}
		}
		// atualiza o registro
		else
		{
			// captura o nome da tabela velha
			$tabela_velha = $componente->alias;

			// se o nome da tabela mudou
			if($tabela_nova != $tabela_velha)
			{
				// verifica se a tabela ja existe
				if($this->existe_tabela($tabela_nova))
					return false;

				// altera o nome da tabela
				JCRUD::query("RENAME TABLE ".ECOMP_TABLE_COMPONENTES."_{$tabela_velha} TO ".ECOMP_TABLE_COMPONENTES."_{$tabela_nova}");

				// atualiza o alias do regitro
				$componente->alias = $tabela_nova;
			}

			// atualiza o registro
			if($componente->update())
			{
				$menu->id              = $componente->idmenuadmin;
				$menu->name            = $componente->nome;
				$menu->admin_menu_alt  = $componente->nome;

				// atualiza o menu
				$menu->update();

				return true;
			}
		}
	}

	function deletar()
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		foreach($cids as $id) {

			// abre a tabela de componentes do ecomp
			$componente = new JCRUD(ECOMP_TABLE_COMPONENTES);
			$componente = $componente->busca_por_id($id);

			// abre a tabela de menu/componentes
			$menu = new JCRUD(ECOMP_TABLE_JCOMPONENTS);

			// apaga o menu
			$menu->delete($componente->idmenuadmin);
			
			// busca todas as tags
			$tags = new JCRUD(ECOMP_TABLE_TAGS);
			$tags = $tags->busca("WHERE idcomponente = '{$componente->id}'");
			foreach($tags as $tag)
			{
				// apaga todos os relacionamento com a tag
				JCRUD::query("DELETE FROM ".ECOMP_TABLE_CADASTROS_TAGS." WHERE idtag = '{$tag->id}'");				
				
				// apaga a tag
				$tag->delete();
			}


			// busca todas as categorias
			$categorias = new JCRUD(ECOMP_TABLE_CATEGORIAS);
			$categorias = $categorias->busca("WHERE idcomponente = '{$componente->id}'");
			foreach($categorias as $categoria)
			{
				// apaga todos os relacionamento com a categoria
				JCRUD::query("DELETE FROM ".ECOMP_TABLE_CADASTROS_CATEGORIAS." WHERE idcategoria = '{$categoria->id}'");
				
				// apaga o categoria
				$categoria->delete();
			}

			// apaga os campos
			JCRUD::query("DELETE FROM ".ECOMP_TABLE_CAMPOS." WHERE idcomponente = '{$componente->id}'");
			
			
			// apaga todas as imagens
			JCRUD::query("DELETE FROM ".ECOMP_TABLE_CADASTROS_IMAGENS." WHERE idcomponente = '{$componente->id}'");
			

			// deleta a tabela do banco
			JCRUD::query("DROP TABLE ".ECOMP_TABLE_COMPONENTES."_{$componente->alias}");

			
			// apaga a pasta de imagen caso exista
			if(JFolder::exists(ECOMP_PATH_IMAGENS.DS.$componente->id))
				JFolder::delete(ECOMP_PATH_IMAGENS.DS.$componente->id);


			// apaga a pasta de uploads
			if(JFolder::exists(ECOMP_PATH_UPLOADS.DS.$componente->id))
				JFolder::delete(ECOMP_PATH_UPLOADS.DS.$componente->id);


			// deleta o componente
			$componente->delete();
		}

		return true;
	}

	function trash($valor)
	{
		$cids = JRequest::getVar( 'cid', array(0), 'request', 'array' );

		foreach($cids as $id)
		{
			// abre a tabela de componentes do ecomp
			$componente = new JCRUD(ECOMP_TABLE_COMPONENTES);
			if(!$componente = $componente->busca_por_id($id))
				break;

			// abre a tabela de menu/componentes
			$menu = new JCRUD(ECOMP_TABLE_JCOMPONENTS);
			if(!$menu = $menu->busca_por_id($componente->idmenuadmin))
				break;

			// busca o id do menu ecomp
			$ecomp_menu = $menu->busca_por_sql("SELECT * FROM @tabela@ WHERE name = 'eComp' AND admin_menu_alt = 'eComp'");

			$menu->enabled = ($valor == 1) ? 0 : 1;
			$menu->parent = ($valor == 1) ? -1 : $ecomp_menu[0]->id;;
			$menu->update();

			// altera o componente
			$componente->trashed = $valor;
			$componente->update();
		}

	}

}
?>
