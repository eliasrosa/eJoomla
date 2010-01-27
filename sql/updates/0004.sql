-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- REQUERIDO 0004

ALTER TABLE `versao_db` CHANGE `requerido_0004` `requerido_0005` BIT(1) NULL DEFAULT NULL;

UPDATE `jos_plugins` SET `params` = 'jqueryAdd=1
jqueryServer=localhost
jqueryVersion=1.4.1
removeMootools=1
removeMootoolsUncompressed=1
removeCaption=1
generator=1
titulo=1
tituloSite={sitename} - {title}
eImageResizeAll=2
eImageResizeClass=eImageResize
eImageNoResizeClass=eImageNoResize
lightBox-active=1
lightBox-overlayOpacity=0.8
lightBox-txtImage=Imagem
lightBox-txtOf=de
firebug-adicionar=0
analytics-adicionar=1
analytics-UA=' WHERE `jos_plugins`.`id` = 36 LIMIT 1;
