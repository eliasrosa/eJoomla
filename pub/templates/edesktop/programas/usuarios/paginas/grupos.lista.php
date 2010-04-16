<? 
$menu_grupos->show();

$grupos = new JCRUD("jos_edesktop_usuarios_grupos");
$grupos = $grupos->busca_tudo("nome ASC");

$this->smarty->assign('grupos', $grupos);

?>
