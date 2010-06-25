<?
// carrega oid do banner
$idbanner = JRequest::getvar('idbanner', 0);

// carrega o menu
$menu_slides->show();

// carrega a biblioteca
jimport('edesktop.programas.banners');

// inicia a lib banners
$banners = new edBanners();

// carrega todos os banners do db
$dados = $banners->busca_todos_slides($idbanner, false);

// envia para o html
$this->smarty->assign('dados', $dados);

?>