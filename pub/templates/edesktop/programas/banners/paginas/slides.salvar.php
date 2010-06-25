<?
// abre a biblioteca de dados
jimport('edesktop.programas.banners');

// carrega a lib
$a = new edBanners();
$r = $a->salva_slide('d1');

// imprime o retorno
jexit(json_encode($r));	
?>