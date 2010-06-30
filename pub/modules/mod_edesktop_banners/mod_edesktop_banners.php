<?php
defined('_JEXEC') or die( "Acesso Restrito" );
jimport('edesktop.programas.banners');

$bannerID = $params->get('bannerID');
$tagID = $params->get('tagID');
$tit = $params->get('titulo');

// abre a class
$edBanners = new edBanners();
$banner = $edBanners->busca_banner_por_id($bannerID);
$slides = $edBanners->busca_todos_slides($bannerID);

JHTML::stylesheet('style.css', $edBanners->url['modelo']);

?>
<div id="<?= $tagID ?>" class="modEdesktopBanners">
	<?= $module->showtitle ? "<h2>$tit</h2>" : ""; ?>
	<div class="corpo">
		<? require($edBanners->path['modelo'] .DS. 'modelo.php'); ?>
	</div>
</div>
