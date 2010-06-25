<?
jimport('edesktop.programas.banners');

$a = new edBanners();
$r = $a->remover_slide('ids');

jexit(json_encode($r));
?>