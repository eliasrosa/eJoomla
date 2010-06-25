-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- REQUERIDO 0015

ALTER TABLE `versao_db` CHANGE `requerido_0015` `requerido_0016` BIT(1) NULL DEFAULT NULL;

-- adiciona tabelas do banners
CREATE TABLE `jos_edesktop_banners` (
	`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`nome` VARCHAR( 255 ) NOT NULL ,
	`largura` INT( 11) NOT NULL ,
	`altura` INT( 11 ) NOT NULL ,
	`modelo` VARCHAR( 255 ) NOT NULL ,
	`allow` VARCHAR( 255 ) NOT NULL,
	`params` LONGTEXT NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

-- 
CREATE TABLE `jos_edesktop_banners_slides` (
	`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`idbanner` INT( 11) NOT NULL ,
	`nome` VARCHAR( 255 ) NOT NULL ,
	`arquivo` VARCHAR( 255 ) NOT NULL,
	`url` VARCHAR( 255 ) NOT NULL,
	`ordem` INT(11) NOT NULL,
	`status` INT(11) NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;



