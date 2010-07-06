<?php
/**
 * Classe com funções úteis
 */
class util
{
	/**
	 * Converte acentos de uma string para html
	 ***********************************************/
	public function acentos2Html($str)
	{
		$ascii = array
		(
			"´", "~", "`", "ç", "^", "'", "á", "é", "í", "ó", "ú", "Á",
			"É", "Í", "Ó", "Ú", "ã", "õ", "Ã", "Õ", "à", "è", "ì", "ò", "ù",
			"À", "È", "Ì", "Ò", "Ù", "â", "ê", "î", "ô", "û", "Â", "Ê", "Î", "Ô", "Û"
		);
		$html = array
		(
			"&cute;", "&tilde;", "&grave;", "&ccedil;", "&circ;", "&acute;",
			"&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&Aacute;",
			"&Eacute", "&Iacute;", "&Oacute;", "&Uacute;", "&atilde;", "&otilde;",
			"&Atilde;", "&Otilde;", "&agrave;", "&egrave;", "&igrave;", "&ograve;",
			"&ugrave;", "&Agrave;", "&Egrave;", "&Igrave;", "&Ograve;", "&Ugrave;",
			"&acirc;", "&ecirc;", "&icirc;", "&ocirc;", "&ucirc;", "&Acirc;", "&Ecirc;", "&Icirc;", "&Ocirc;", "&Ucirc;"
		);
		return str_replace($ascii, $html, $str);
	}


	/**
	 * Retorna valor seguro para o banco de dados
	 ***********************************************/
	public function quote($value, $trim = true)
	{
		if($trim)
			$value = trim($value);
			
		$value = addslashes($value);		
		return $value;
	}

	/**
	 * Retorna valor inteiro
	 ***********************************************/
	public function int($int, $default = 0)
	{
		if(preg_match("#^-?\d+$#", $int))		
			return $int;
		else
			return $default;
	}


	/**
	 * Converte data mysql p/ normal e vice-versa
	 ***********************************************/
	function converteData($data) {
		if (strpos($data, "/") === false) return join("/", array_reverse(split("-", $data)));
		else return join("-", array_reverse(split("/", $data)));
	}


	/**
	 * Remove códigos Html da string
	 ***********************************************/
	public function removeHtml($s)
	{
		return htmlspecialchars(Util::quote(iconv("UTF-8", "iso-8859-1", $s)));
	}
}
?>
