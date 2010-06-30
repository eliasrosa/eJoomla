<?
// carrega omenu
$menu_slides->show();

// carrega a var get id
$id = JRequest::getvar('id', 0);
$idbanner = JRequest::getvar('idbanner', 0);

// carrega a lib de banners
jimport('edesktop.programas.banners');

// inicia a lib
$banner = new edBanners();

// carrega os dados do banner
$ban = $banner->busca_banner_por_id($idbanner);

// envia os dados
$this->smarty->assign('banner', $ban);

$config = $banner->busca_config_modelo();
$arquivosPermitidos = join(', ', $config['arquivos.permitidos']);

$this->smarty->assign('arquivosPermitidos', $arquivosPermitidos);

// busca banner por id
$dados = $banner->busca_slide_por_id($id);

// dados dafault 
if(!$id)
	$dados = $banner->busca_default_values('slides');

// envia os dados	
$this->smarty->assign('dados', $dados);


?>