<?
@header('Content-Type: text/html; charset=utf-8');
@session_start();


/* Defines path do eDesktop
 *************************************************/
define('EDESKTOP_PATH', dirname(__FILE__));
define('EDESKTOP_PATH_INC', EDESKTOP_PATH .DS. 'inc');
define('EDESKTOP_PATH_PROGRAMAS', EDESKTOP_PATH .DS. 'programas');
define('EDESKTOP_PATH_CACHE', JPATH_ROOT .DS. 'cache' .DS. 'edesktop');
define('EDESKTOP_PATH_SMARTY_CACHE', EDESKTOP_PATH_CACHE .DS. 'cache');
define('EDESKTOP_PATH_SMARTY_COPILE', EDESKTOP_PATH_CACHE .DS. 'copile');



/* Defines url do eDesktop
 *************************************************/
define('EDESKTOP_URL', "{$this->baseurl}/templates/{$this->template}");
define('EDESKTOP_URL_JS', EDESKTOP_URL. "/js");
define('EDESKTOP_URL_CSS', EDESKTOP_URL. "/css");
define('EDESKTOP_URL_IMG', EDESKTOP_URL. "/img");



/* Defines padrões do eDesktop
 *************************************************/
define('EDESKTOP_TOKEN', JUtility::getToken());
define('EDESKTOP_TEMPLATE', $this->template);


$user =& JFactory::getUser();
if($user->guest)
{
	$erro  = JRequest::getvar('erro', false);
	$return	= 'index.php?template=edesktop';
	$credentials = array();
	$credentials['username'] = JRequest::getVar('username', '', 'method', 'username');
	$credentials['password'] = JRequest::getString('passwd', '', 'post', JREQUEST_ALLOWRAW);	
	
	
	if(!empty($credentials['username']) || !empty($credentials['password']) )
	{
		// Check for request forgeries
		JRequest::checkToken('request') or jexit( 'eDesktop: Invalid Token' );
	
		//preform the login action
		$error = $mainframe->login($credentials);
		
		if(!JError::isError($error))
		{
			$mainframe->redirect( $return );
		}
		else
		{
			$mainframe->redirect( $return. '&erro=1' );
		}		
	}
		
	require_once(EDESKTOP_PATH .DS. "login.php");
	exit();
}
else
{
	
	/* logout
	 *************************************************/
	$logout = JRequest::getvar('logout', false);
	if($logout)
	{
		
		//preform the logout action
		$error = $mainframe->logout();

		if(!JError::isError($error))
		{
			$return	= 'index.php?template=edesktop';
			$mainframe->redirect( $return );
		}
	
	}
	else
	{
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
			require_once(EDESKTOP_PATH .DS. "home.php");
	}
}
?>
