-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- REQUERIDO 0016

ALTER TABLE `versao_db` CHANGE `requerido_0016` `requerido_0017` BIT(1) NULL DEFAULT NULL;

-- remove o campo allow
ALTER TABLE `jos_edesktop_banners` DROP `allow`;

-- adicionado o campo target
ALTER TABLE `jos_edesktop_banners_slides` ADD `target` VARCHAR( 100 ) NOT NULL AFTER `url`;



