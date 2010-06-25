<?
// carrega o menu
$menu_principal->show();

// carrega a biblioteca
jimport('edesktop.programas.banners');

// inicia a lib banners
$banners = new edBanners();

// carrega todos os banners do db
$banners = $banners->busca_todos_banners();

// envia para o html
$this->smarty->assign('banners', $banners);

// permições
$this->smarty->assign('editar', jAccess('banners.editar', array('retorno' => 'bool')));
$this->smarty->assign('remover', jAccess('banners.remover', array('retorno' => 'bool')));
$this->smarty->assign('admin', jAccess('banners.admin', array('retorno' => 'bool')));

?>
