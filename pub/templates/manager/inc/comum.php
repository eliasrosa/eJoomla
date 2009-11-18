<?
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

@session_start();

// Emular IE7
header("X-UA-Compatible: IE=EmulateIE7");

$base = "{$this->baseurl}/templates/{$this->template}";

// carrega os aquivos
require_once(JPATH_ROOT.DS.'media'.DS.'com_ecomp'.DS.'comum.php');
require_once(ECOMP_PATH_CLASS.DS.'ebasic.jcrud.php');

// Login
require_once('manager.login.php');

$login = new manager_login();
$login->verificar();

?>
