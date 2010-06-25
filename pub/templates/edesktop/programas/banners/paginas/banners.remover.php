<?
jimport('edesktop.programas.banners');

$a = new edBanners();
$r = $a->remover_banner('ids');

jexit(json_encode($r));
?>