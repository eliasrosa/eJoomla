<?
// carrega omenu
$menu_principal->show();

// carrega a var get id
$id = JRequest::getvar('id', 0);

// carrega a lib de banners
jimport('edesktop.programas.banners');

// inicia a lib
$banner = new edBanners();

// busca banner por id
$dados = $banner->busca_banner_por_id($id);

// dados dafault 
if(!$id)
	$dados = $banner->busca_default_values('banners');

// busca modelos
$modelos = $banner->busca_todos_modelos_banners();

// envia os dados	
$this->smarty->assign('banner', $dados);
$this->smarty->assign('modelos', $modelos);

?>