<?
@header('Content-Type: text/html; charset=utf-8');
@session_start();



/* Defines path do eDesktop
 *************************************************/
define('EDESKTOP_PATH', dirname(__FILE__));
define('EDESKTOP_PATH_PROGRAMAS', EDESKTOP_PATH .DS. 'programas');



/* Defines url do eDesktop
 *************************************************/
define('EDESKTOP_URL', "{$this->baseurl}/templates/{$this->template}");
define('EDESKTOP_URL_JS', EDESKTOP_URL. "/js");
define('EDESKTOP_URL_CSS', EDESKTOP_URL. "/css");
define('EDESKTOP_URL_IMG', EDESKTOP_URL. "/img");



/* Defines padrões do eDesktop
 *************************************************/
define('EDESKTOP_TEMPLATE', "{$this->template}");



/* Recebe a funcão
 *************************************************/
$method = JRequest::getvar('method', false);
$class = JRequest::getvar('class', false);



// Caso exista uma class e função
if($class && $method)
{

	jimport("edesktop.{$class}");
	
	if(method_exists($class, $method))
	{
		$class = new $class();
		$class->$method();
	}
	else
		echo "Method '{$method}' não econtrado na class '{$class}'!";

}
else
	require_once(EDESKTOP_PATH .DS. "index2.php");
?>
