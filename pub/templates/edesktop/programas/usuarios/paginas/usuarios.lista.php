<?
$menu_principal->show();

$usuarios = new JCRUD("jos_users");
$usuarios = $usuarios->busca_tudo("name ASC");

$this->smarty->assign('usuarios', $usuarios);


$user =& JFactory::getUser();
$this->smarty->assign('user', $user);
?>
