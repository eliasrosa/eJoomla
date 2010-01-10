<?php
// evitar acesso direto
defined( '_JEXEC' ) or die( 'Acesso restrito' );

abstract class eLoadHelper
{
	function cria_imagem($imagem, $largura = null, $altura = null, $fit = 'inside', $scale = 'any', $wm = false)
	{

		$imagem = JPATH_BASE.DS.$imagem;		

		// se a imagem não existir
		if(!JFile::exists($imagem))
			// retorna o mesmo camiho com a variavel noexists=1 adicionada
			return $imagem.'?eload=noexists';

		// abre a clase Imagem
		require_once('wideimage'.DS.'lib'.DS.'WideImage.inc.php');

		// se a largura e a altura forem null
		if(is_null($largura) && is_null($altura))
		{
			// pega a largura e altura da imagem original
			$largura = wiImage::load($imagem)->getWidth();
			$altura  = wiImage::load($imagem)->getHeight();
		}

		// remover a extenção
		$imagemName = JFile::stripExt($imagem);

		// remove as barras do nome
		$imagemName = str_replace('/', '-', $imagemName);
		

		// Pasta para a imagem com base nos 10 primeiros caracteres do seu sha1
		$imagemDir = 'cache/eload/'.substr(sha1_file($imagem), 0, 10);

		// se a pasta não existir
		if(!is_dir(JPATH_BASE.DS.$imagemDir))
			// tenta criar a mesma
			mkdir(JPATH_BASE.DS.$imagemDir);

		$wminfo  = ""; // caminho para o txt com informações da imagem com marca(s) d'água
		$wmsha1  = ""; // sha1 das imagens de marca d'água
		$wmpsha1 = ""; // sha1 dos parametros

		if (is_array($wm) && count($wm))
		{
			$wminfo = JPATH_BASE.DS.$imagemDir.'/'.substr(sha1("{$imagem}_{$largura}x{$altura}_{$fit}_{$scale}"), 0, 8).".txt";
			foreach ($wm as $marca)
			{
				$wmsha1 .= substr(sha1_file($marca[0]), 0, 4);
				$wmpsha1 .= substr(sha1($marca[6]), 0, 4);
			}
		}

		$novaImagem = "{$imagem}_{$largura}x{$altura}_{$fit}_{$scale}{$wmsha1}";

		// sha1 do nome do arquivo
		$novaImagem = substr(sha1($novaImagem), 0, 8);

		// adiciona a ext no arquivo
		$novaImagem = $novaImagem.'.'.JFile::getExt($imagem);

		// cria a string com o endereço da nova imagem
		$cache = "{$imagemDir}/{$novaImagem}";

		if (!empty($wminfo))
		{
			if (!file_exists($wminfo))
				file_put_contents($wminfo, "$novaImagem|$wmpsha1");
			else
			{
				$wmold = file_get_contents($wminfo);
				$wmoldinfo = explode('|', $wmold);
				if ($novaImagem != $wmoldinfo[0] || $wmpsha1 != $wmoldinfo[1])
				{
					if (file_exists(JPATH_BASE.DS.$imagemDir.'/'.$wmoldinfo[0]))
						unlink(JPATH_BASE.DS.$imagemDir.'/'.$wmoldinfo[0]);
					file_put_contents($wminfo, "$novaImagem|$wmpsha1");
				}
			}
		}

		// se a imagem não existir
		if(!file_exists(JPATH_BASE.DS.$cache))
		{
			$novaimagem = wiImage::load($imagem)->resize($largura, $altura, $fit, $scale);

			if (is_array($wm) && count($wm))
			{
				foreach ($wm as $marca)
				{
					$menor = ($largura < $altura) ? $largura : $altura;

					$imgmarca = wiImage::load($marca[0])->resize($marca[2], $marca[3], 'inside', 'down');

					switch ($marca[1])
					{
						case 'tl':
							$v = $marca[4];
							$h = $marca[5];
							break;
						case 'tc':
							$v = $marca[4];
							$h = ($novaimagem->getWidth() - $imgmarca->getWidth()) / 2;
							break;
						case 'tr':
							$v = $marca[4];
							$h = $novaimagem->getWidth() - $imgmarca->getWidth() - $marca[5];
							break;
						case 'bl':
							$v = $novaimagem->getHeight() - $imgmarca->getHeight() - $marca[4];
							$h = $marca[5];
							break;
						case 'bc':
							$v = $novaimagem->getHeight() - $imgmarca->getHeight() - $marca[4];
							$h = ($novaimagem->getWidth() - $imgmarca->getWidth()) / 2;
							break;
						case 'br':
							$v = $novaimagem->getHeight() - $imgmarca->getHeight() - $marca[4];
							$h = $novaimagem->getWidth() - $imgmarca->getWidth() - $marca[5];
							break;
						case 'cc':
							$v = ($novaimagem->getHeight() - $imgmarca->getHeight()) / 2;
							$h = ($novaimagem->getWidth() - $imgmarca->getWidth()) / 2;
							break;
					}
					$novaimagem = $novaimagem->merge($imgmarca, $h, $v);
				}
			}

			$novaimagem->saveToFile(JPATH_BASE.DS.$cache, null, 90);
		}

		// se estiver usando re_write e o sef
		if(strlen(JURI::base(1)) > 1)
			$cache = JURI::base(1) . '/' . $cache;

		return $cache;

	}

	function watermark_info($wm)
	{
		$retorno = array();
		$marcasdagua = explode('|', $wm);

		foreach ($marcasdagua as $marca)
		{
			$info = explode(',', $marca);

			/**
			 * indices da array:
			 * 
			 * [0] caminho da imagem
			 * [1] posição (tl, tc, tr, bl, bc, br, cc)
			 * [2] largura
			 * [3] altura
			 * [4] margem vertical
			 * [5] margem horizontal
			 * [6] string original com parametros separados por virgula
			 */ 
			
			if (count($info) == 3) // seta a altura da marca igual a largura
				$info[3] = $info[2];
			if (count($info) == 4) // seta o top left para 0
				$info[4] = $info[5] = 0;
			if (count($info) == 5) // seta o left igual ao top
				$info[5] = $info[4];

			// pega as imagens do cadastro
			$imagem = new JCRUD(ECOMP_TABLE_CADASTROS_IMAGENS);
			$imagem = $imagem->busca_por_id($info[0]);

			if ($imagem)
			{
				$info[0] = JPATH_BASE.DS.ECOMP_URL_IMAGENS."/{$imagem->file}";
				$info[6] = $marca;
				$retorno[] = $info;
			}
		}

		return $retorno;
	}

	function watermark_aplicar()
	{
		
	}
}
?>
