-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- REQUERIDO 0017

ALTER TABLE `versao_db` CHANGE `requerido_0017` `requerido_0018` BIT(1) NULL DEFAULT NULL;


-- inseri a tabela de e-mails
CREATE TABLE `jos_edesktop_mailing_emails` (
	`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`idremetente` INT( 11 ) NOT NULL ,
	`nome` VARCHAR( 255 ) NOT NULL ,
	`assunto` VARCHAR( 255 ) NOT NULL ,
	`html` LONGTEXT NOT NULL ,
	`status` INT( 11 ) NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;


-- inseri a tabela de remetentes
CREATE TABLE `jos_edesktop_mailing_remetentes` (
	`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`nome` VARCHAR( 255 ) NOT NULL ,
	`email` VARCHAR( 255 ) NOT NULL ,
	`departamento` VARCHAR( 255 ) NOT NULL ,
	`status` INT( 11 ) NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;


-- inseri a tabela de contatos
CREATE TABLE `jos_edesktop_mailing_contatos` (
	`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`nome` VARCHAR( 255 ) NOT NULL ,
	`email` VARCHAR( 255 ) NOT NULL ,
	`status` INT( 11 ) NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;


-- inseri a tabela de envios
CREATE TABLE `jos_edesktop_mailing_envios` (
	`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`idemail` INT( 11 ) NOT NULL ,
	`idcontato` INT( 11 ) NOT NULL ,
	`idusuario` INT( 11 ) NOT NULL ,
	`datahora` DATETIME NOT NULL ,
	`visualizado` INT( 11 ) NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

