<?php
abstract class eUtil
{
	function texto_limpo($text, $hifen = false)
	{
		jimport('joomla.filter.output');
		$text = JFilterOutput::stringURLSafe($text);

		if(!$hifen)
			$text = str_replace('-', '', $text);


		return $text;
	}

	/**
	 * Converte data mysql p/ normal e vice-versa
	 *
	 * @param string $data
	 * @param boolean $mysql
	 * @return string
	 */
	function converteData($data) {
		if (empty($data))
			return "";
		if (strpos($data, "/") === false) return join("/", array_reverse(split("-", $data)));
		else return join("-", array_reverse(split("/", $data)));
	}

	function joinCampo($array, $campo = "id", $sep = ", ")
	{
		$ret = array();

		foreach ($array as $item)
			$ret[] = $item->$campo;

		return join($sep, $ret);
	}
}
?>
