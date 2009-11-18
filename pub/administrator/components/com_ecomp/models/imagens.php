<?php
// evitar acesso direto
defined('_JEXEC') or die('Acesso restrito');

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

class ecompMODELimagens extends ebasicModel
{
	function __construct()
	{
		parent::__construct();

		$idcomponente = JRequest::getVar('idcomponente', 0);
		$idcadastro   = JRequest::getVar('idcadastro', 0);

		$this->_queryListagem = "SELECT * FROM ".ECOMP_TABLE_CADASTROS_IMAGENS." WHERE %where% AND idcomponente = {$idcomponente} AND idcadastro = {$idcadastro} ORDER BY ordering, id DESC, legenda ASC";
		$this->_queryCadastro = "SELECT * FROM ".ECOMP_TABLE_CADASTROS_IMAGENS." WHERE %where% AND idcomponente = {$idcomponente} AND idcadastro = {$idcadastro} ORDER BY ordering, legenda ASC";
	}

	function salvar()
	{
		require_once(ECOMP_PATH_CLASS.DS.'wideimage'.DS.'lib'.DS.'WideImage.inc.php');

		// carrega o post
		$dados = $_POST;

		$idcomponente = JRequest::getVar('idcomponente', 0);
		$idcadastro   = JRequest::getVar('idcadastro', 0);

		$path_dest = ECOMP_PATH_IMAGES.DS.$idcomponente.DS.$idcadastro;

		$file      = JRequest::getVar('Filedata', null, 'files', 'array');
		$file_name = JFile::makeSafe($file['name']);
		$file_ext  = strtolower(JFile::getExt($file_name));
		$file_tmp  = $file['tmp_name'];

		if ($file_ext != 'png')
			$file_ext = 'jpg';

		$js = JRequest::getVar('js', 0);

		// remove variaveis inuteis
		unset($dados['Filedata'], $dados['Filename'], $dados['sid'], $dados['task'], $dados['view'], $dados['option'], $dados['js'], $dados['Upload'], $dados['layout']);

		// carrega os dados
		$imagem =  new JCRUD(ECOMP_TABLE_CADASTROS_IMAGENS, $dados);

		if($imagem->id) $imagem->update();
		else $imagem->insert();

		if($file['error'] != 4)
		{
			$file_dest = $path_dest.DS.$imagem->id.'.'.$file_ext;
			$file_new  = $path_dest.DS.$imagem->id.'.redimensionada.'.$file_ext;
			$file_db   = $imagem->id.'.'.$file_ext;

			$file_p    = $path_dest.DS.$imagem->id.'_p.jpg';
			$file_m    = $path_dest.DS.$imagem->id.'_m.jpg';

			//die(print_r($file , true));
			if(JFile::upload($file_tmp, $file_dest))
			{
				if ($file_ext != 'png')
				{
					wiImage::load($file_dest)->resize(1024, 1024, 'inside', 'down')->saveToFile($file_new, null, 90);

					// Cria imagem 800x600
					$file_800 = $path_dest.DS.$imagem->id.'800x600.jpg';
					ecompHelper::redimensionaImg($file_new, $file_800, 800, 600, 'inside', 'down', 90);

					// Cria imagem 640x480
					$file_640 = $path_dest.DS.$imagem->id.'640x480.jpg';
					ecompHelper::redimensionaImg($file_new, $file_640, 640, 480, 'inside', 'down', 90);

					// Cria imagem 320x240
					$file_320 = $path_dest.DS.$imagem->id.'320x240.jpg';
					ecompHelper::redimensionaImg($file_new, $file_320, 320, 240, 'inside', 'down', 90);
				}
				else
					JFile::copy($file_dest, $file_new);

				// apaga a imagem grande
				unlink($file_dest);

				// se o nome do arquivo cadastro anteriormente for diferente
				if($imagem->file != $file_db)
				{
					// apaga o arquivo velhos
					@unlink($path_dest.DS.$imagem->file);
					@unlink($file_p);
					@unlink($file_m);
				}

				// renomeia a imagem redimencionada pela o destino
				JFile::move($file_new, $file_dest);

				// cria a imagem mini
				wiImage::load($file_dest)->resize(100, 100, 'inside', 'down')->saveToFile($file_p, null, 90);

				// cria a imagem mini
				wiImage::load($file_dest)->resize(250, 250, 'inside', 'down')->saveToFile($file_m, null, 90);

				// muda o nome do arquivo no banco
				$imagem->file = $file_db;

				// atualiza o banco de dados
				$imagem->update();
			}
		}

		// se o post for enviado por js
		if($js == "1")
		{
			echo 'texto de ok!';
			jexit();
		}
		return true;
	}

	function deletar()
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		foreach($cids as $id) {
			// carrega os dados
			$imagem = new JCRUD(ECOMP_TABLE_CADASTROS_IMAGENS, array( 'id' => $id));

			// apaga as imagens
			unlink(ECOMP_PATH_IMAGES.DS.$imagem->idcomponente.DS.$imagem->idcadastro.DS.$imagem->file);
			unlink(ECOMP_PATH_IMAGES.DS.$imagem->idcomponente.DS.$imagem->idcadastro.DS.str_replace('.', '_p.', $imagem->file));
			unlink(ECOMP_PATH_IMAGES.DS.$imagem->idcomponente.DS.$imagem->idcadastro.DS.str_replace('.', '_m.', $imagem->file));

			// deleta o componente
			$imagem->delete();
		}

		return true;
	}

}
?>
