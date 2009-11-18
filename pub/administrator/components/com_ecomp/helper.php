<?php
// evitar acesso direto
defined('_JEXEC') or die('Acesso restrito');

class ecompHelper
{
	function redimensionaImg($original, $destino, $width, $height, $fit, $scale, $qualidade = 90)
	{
		$imagem = wiImage::load($original);

		if ($imagem->getWidth() > $width || $imagem->getHeight() > $height)
			$imagem->resize($width, $height, $fit, $scale)->saveToFile($destino , null, $qualidade);
		else
			if (file_exists($destino))
				JFile::delete($destino);
	}
}
?>
