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
$method = JRequest::getvar('_m', false);
$class = JRequest::getvar('_c', false);


// Caso exista uma class e função
if($class && $method)
{
	$class_file = EDESKTOP_PATH .DS. 'funcoes' .DS. $class . '.php';
	if(file_exists($class_file))
	{
		require_once($class_file);
		if(method_exists($class, $method))
		{
			$class = new $class();
			$class->$method();
		}
		else
			echo "Method '{$method}' não econtrado!";
	}
	else
		echo "Class '{$class}' não econtrada!";
		
}
else
	require_once(EDESKTOP_PATH .DS. "index2.php");
?>
