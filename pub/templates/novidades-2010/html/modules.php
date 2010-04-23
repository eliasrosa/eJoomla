<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

/*
 * Estilo limpo
 */
function modChrome_limpo($module, &$params, &$attribs)
{
	if (!empty($module->content))
	{
		echo $module->content;
	}
}
?>
