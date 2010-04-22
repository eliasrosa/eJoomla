<?
$menu_principal->show();
$id = JRequest::getvar('id', 0);


$usuario = new JCRUD("jos_users");
$usuario = $usuario->busca_por_id($id);
$this->smarty->assign('usuario', $usuario);


$grupos = new JCRUD("jos_edesktop_usuarios_grupos");
$grupos = $grupos->busca_tudo("nome ASC");
$this->smarty->assign('grupos', $grupos);


$user =& JFactory::getUser();
$this->smarty->assign('user', $user);


// Permissões
$params = array('retorno' => 'bool');
$this->smarty->assign('alterarUsuarioSenha', jAccess('usuarios.alterarUsuarioSenha', $params));
$this->smarty->assign('alterarGrupoJoomla', jAccess('usuarios.alterarGrupoJoomla', $params));
$this->smarty->assign('bloquearUsuarios', jAccess('usuarios.bloquearUsuarios', $params));

?>
