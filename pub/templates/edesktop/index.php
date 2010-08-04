<?
jimport( 'joomla.environment.browser' );
$b =& JBrowser::getInstance();
if($b->getBrowser() != 'mozilla')
{
	header ('Content-type: text/html; charset=utf-8');

	$erroBrowserHtml = '<p class="aviso">Por questões de segurança e desempenho, este programa requer a utilização do navegador Mozilla Firefox.</p><p><a href="http://br.mozdev.org/download/">Download Mozilla Firefox</a></p>';	
	jexit($erroBrowserHtml);
}

require_once('inc/edesktop.class.php');
$edek = new eDesktop($this);
?>
