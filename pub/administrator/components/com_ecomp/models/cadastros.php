<?php
// evitar acesso direto
defined('_JEXEC') or die('Acesso restrito');

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

class ecompMODELcadastros extends ebasicModel
{
	function __construct()
	{
		parent::__construct();

		$idcomponente = JRequest::getVar('idcomponente', 0);
		$componente = new JCRUD(ECOMP_TABLE_COMPONENTES, array( 'id' => $idcomponente));

		$this->_campoTrashed  = "trashed";
		$this->_queryListagem = "SELECT * FROM ".ECOMP_TABLE_COMPONENTES."_{$componente->alias} WHERE %where% ORDER BY ordering ASC";
		$this->_queryCadastro = "SELECT * FROM ".ECOMP_TABLE_COMPONENTES."_{$componente->alias} WHERE %where% ORDER BY ordering ASC";
	}

	function salvar()
	{
		require_once(ECOMP_PATH_CLASS.DS.'ebasic.util.php');
		require_once(ECOMP_PATH_CLASS.DS.'wideimage'.DS.'lib'.DS.'WideImage.inc.php');

		$idcomponente = JRequest::getVar('idcomponente', 0);
		$post         = $_POST;
		$dados        = array('id' => $post['id'], 'published' => $post['published'], 'ordering' => $post['ordering']);


		foreach($post['dados'] as $idcampo => $v)
		{
			// abre o campo
			$campo = new JCRUD(ECOMP_TABLE_CAMPOS, array( 'id' => $idcampo));

			$coluna = key($v);
			$valor = str_replace('$id', $post['id'], stripslashes($v[$coluna]));
			$dados[$coluna] = $valor;

			//data
			if($campo->idtipo == 6)
			{
				$dados[$coluna] = eUtil::converteData($valor);
			}
		}

		// abre o componente
		$componente = new JCRUD(ECOMP_TABLE_COMPONENTES, array( 'id' => $idcomponente));

		// abre o cadastro
		$cadastro = new JCRUD(ECOMP_TABLE_COMPONENTES."_{$componente->alias}", $dados);

		// apaga o relacionamento antigo com as tags e categorias
		JCRUD::query("DELETE FROM ".ECOMP_TABLE_CADASTROS_TAGS." WHERE idcomponente = '{$idcomponente}' AND idcadastro = {$cadastro->id}");
		JCRUD::query("DELETE FROM ".ECOMP_TABLE_CADASTROS_CATEGORIAS." WHERE idcomponente = '{$idcomponente}' AND idcadastro = {$cadastro->id}");

		//
		if($cadastro->id)
			$cadastro->update();
		else
			$cadastro->insert();

		// cadastra as tags
		$tags = new JCRUD(ECOMP_TABLE_CADASTROS_TAGS);
		if (isset($post['tags']))
		{
			foreach($post['tags'] as $tag)
			{
				$tags->id = null;
				$tags->idcomponente = $idcomponente;
				$tags->idcadastro = $cadastro->id;
				$tags->idtag = $tag;
				$tags->insert();
			}
		}

		// cadastra as categorias
		$categorias = new JCRUD(ECOMP_TABLE_CADASTROS_CATEGORIAS);
		if (isset($post['categorias']))
		{
			foreach($post['categorias'] as $cat)
			{
				$categorias->id = null;
				$categorias->idcomponente = $idcomponente;
				$categorias->idcadastro = $cadastro->id;
				$categorias->idcategoria = $cat;
				$categorias->insert();
			}
		}

		////////////////////////////////////////////////////
		// uploads
		////////////////////////////////////////////////////
		$uploads = count($_FILES['dados']) ? $_FILES['dados'] : array();
		foreach($uploads['name'] as $idcampo => $coluna)
		{
			$campo  = new JCRUD(ECOMP_TABLE_CAMPOS, array( 'id' => $idcampo));
			$coluna = key($coluna);

			$tipo = new JCRUD(ECOMP_TABLE_TIPOS, array( 'id' => $campo->idtipo));

			parse_str($tipo->params, $params1);
			parse_str($campo->params, $params2);
			$params = array_merge($params1, $params2);

			//upload de imagem
			if($campo->idtipo == 11 && $uploads['error'][$idcampo][$coluna] != 4)
			{

				$path_dest = ECOMP_PATH_IMAGES_UPLOADS.DS.$idcomponente.DS.$cadastro->id;

				$file      = $uploads;
				$file_ext  = strtolower(JFile::getExt($file['name'][$idcampo][$coluna]));
				$file_name = $coluna.'.'.$file_ext;
				$file_tmp  = $file['tmp_name'][$idcampo][$coluna];

				$file_dest = $path_dest.DS.$file_name;

				if(strpos($params['ext'], $file_ext) !== false)
				{
					// eLoad - Salva o caminho da pasta cache atual
					if(file_exists($file_dest))
						$cache_dir = ECOMP_PATH_CACHE_ELOAD.DS.substr(sha1_file($file_dest), 0, 10);


					if(JFile::upload($file_tmp, $file_dest))
					{
						// eLoad - Apaga a pasta cache anterior
						if (isset($cache_dir) && is_dir($cache_dir))
							JFolder::delete($cache_dir);

						// apaga o arquivo
						if($cadastro->$coluna != $file_name)
							@unlink($path_dest.DS.$cadastro->$coluna);

						if($params['resize'] == 1)
						{
							if($file_ext != 'gif' || ($file_ext == 'gif' && $params['resize_gif'] == 1))
							{
								$imagem = wiImage::load($file_dest);

								if ($imagem->getWidth() > $params['width'] || $imagem->getHeight() > $params['height'])
									wiImage::load($file_dest)->resize($params['width'], $params['height'], $params['fit'], $params['scale'])->saveToFile($file_dest , null, 90);

								// Cria imagem 800x600
								$file_800 = $path_dest.DS.$coluna.'800x600.'.$file_ext;
								ecompHelper::redimensionaImg($file_dest, $file_800, 800, 600, $params['fit'], $params['scale'], 90);

								// Cria imagem 640x480
								$file_640 = $path_dest.DS.$coluna.'640x480.'.$file_ext;
								ecompHelper::redimensionaImg($file_dest, $file_640, 640, 480, $params['fit'], $params['scale'], 90);

								// Cria imagem 320x240
								$file_320 = $path_dest.DS.$coluna.'320x240.'.$file_ext;
								ecompHelper::redimensionaImg($file_dest, $file_320, 320, 240, $params['fit'], $params['scale'], 90);
							}
						}

						// altera o nome da imagem
						$cadastro->$coluna = $file_name;
					}
				}
			}

			//upload
			if($campo->idtipo == 4 && $uploads['error'][$idcampo][$coluna] != 4)
			{
				$path_dest = ECOMP_PATH_UPLOADS.DS.$idcomponente.DS.$cadastro->id;

				$file      = $uploads;
				$file_ext  = strtolower(JFile::getExt($file['name'][$idcampo][$coluna]));
				$file_name = $coluna.'.'.$file_ext;
				$file_tmp  = $file['tmp_name'][$idcampo][$coluna];

				$file_dest = $path_dest.DS.$file_name;

				// apaga o arquivo
				@unlink($path_dest.DS.$cadastro->$coluna);

				if(JFile::upload($file_tmp, $file_dest))
				{
					// altera o nome da imagem
					$cadastro->$coluna = $file_name;
				}
			}

			// salva os dados
			$cadastro->update();
		}

		return true;
	}

	function trash($valor)
	{
		$cids = JRequest::getVar( 'cid', array(0), 'request', 'array' );

		foreach($cids as $id)
		{
			$idcomponente = JRequest::getVar('idcomponente', 0);

			// abre a tabela de componentes do ecomp
			$componente = new JCRUD(ECOMP_TABLE_COMPONENTES, array( 'id' => $idcomponente));

			// abre a tabela de cadastro
			$cadastro = new JCRUD(ECOMP_TABLE_COMPONENTES."_{$componente->alias}", array( 'id' => $id ));

			//
			$cadastro->trashed = $valor;
			$cadastro->update();
		}
	}

	function deletar()
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		foreach($cids as $id) {

			$idcomponente = JRequest::getVar('idcomponente', 0);

			// abre a tabela de componentes do ecomp
			$componente = new JCRUD(ECOMP_TABLE_COMPONENTES, array( 'id' => $idcomponente));

			// abre a tabela de cadastro
			$cadastro = new JCRUD(ECOMP_TABLE_COMPONENTES."_{$componente->alias}", array( 'id' => $id ));

			// apaga a pasta de imagen caso exista
			if(JFolder::exists(ECOMP_PATH_IMAGES.DS.$idcomponente.DS.$id))
				JFolder::delete(ECOMP_PATH_IMAGES.DS.$idcomponente.DS.$id);

			// apaga a pasta de imagens uploads
			if(JFolder::exists(ECOMP_PATH_IMAGES_UPLOADS.DS.$idcomponente.DS.$id))
				JFolder::delete(ECOMP_PATH_IMAGES_UPLOADS.DS.$idcomponente.DS.$id);

			// apaga a pasta de uploads
			if(JFolder::exists(ECOMP_PATH_UPLOADS.DS.$idcomponente.DS.$id))
				JFolder::delete(ECOMP_PATH_UPLOADS.DS.$idcomponente.DS.$id);

			// apaga todos os relacinamento do cadastro com as categorias
			JCRUD::query("DELETE FROM ".ECOMP_TABLE_CADASTROS_CATEGORIAS." WHERE idcomponente = '{$idcomponente}' AND idcadastro = '{$id}'");

			// apaga todos os relacinamento do cadastro com as tags
			JCRUD::query("DELETE FROM ".ECOMP_TABLE_CADASTROS_TAGS." WHERE idcomponente = '{$idcomponente}' AND idcadastro = '{$id}'");

			// apaga todas as imagens relacionadas com o cadastro
			JCRUD::query("DELETE FROM ".ECOMP_TABLE_CADASTROS_IMAGENS." WHERE idcomponente = '{$idcomponente}' AND idcadastro = '{$id}'");

			// deleta o componente
			$cadastro->delete();
		}

		return true;
	}

	function publish($valor)
	{
		$cids = JRequest::getVar( 'cid', array(0), 'request', 'array' );

		foreach($cids as $id)
		{
			$idcomponente = JRequest::getVar('idcomponente', 0);

			// abre a tabela de componentes do ecomp
			$componente = new JCRUD(ECOMP_TABLE_COMPONENTES, array( 'id' => $idcomponente));

			// abre a tabela de cadastro
			$cadastro = new JCRUD(ECOMP_TABLE_COMPONENTES."_{$componente->alias}", array( 'id' => $id ));

			//
			$cadastro->published = $valor;
			$cadastro->update();
		}
	}


}
?>
