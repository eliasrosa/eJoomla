<?
// carrega a var get id
$id = JRequest::getvar('id', 0);

// carrega a lib de banners
jimport('edesktop.programas.banners');

// inicia a lib
$banner = new edBanners();
$dados = $banner->busca_slide_por_id($id);

// envia os dados	
$this->smarty->assign('dados', $dados);

?>