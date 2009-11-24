<?
	// abre os cadastros
	$cadastros = new JCRUD($tabela);
	$cadastros = $cadastros->busca("WHERE trashed != '1' AND published = '1' ORDER BY ordering ASC");

	if (is_array($cadastros) && count($cadastros) > 0)
	{
		foreach($cadastros as $cadastro)
		{
			// pega as imagens do cadastro
			$imagens = new JCRUD(ECOMP_TABLE_CADASTROS_IMAGENS);
			$imagens = $imagens->busca("WHERE idcomponente = '{$idcomponente}' AND idcadastro = '{$cadastro->id}' AND trashed != '1' AND published = '1' ORDER BY ordering ASC");


			// carrega a imagem com o caminho completo
			foreach($imagens as $k=>$v)
			{
				$imagens[$k]->file = ECOMP_URL_IMAGENS."/".$imagens[$k]->file;
			}


			// carrega as imagens no cadastro
			$cadastro->_imagens = $imagens;
		}
		
	}
	else
	{	
		// nenhum registro encontrado
		$cadastros = array();
	}
	
	

?>
