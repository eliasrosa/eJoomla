-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- REQUERIDO 0019

ALTER TABLE `versao_db` CHANGE `requerido_0019` `requerido_0020` BIT(1) NULL DEFAULT NULL;

-- altera o nome da tabela de controle de versao
RENAME TABLE `versao_db`  TO `jos_ejoomla_v0020` ;

-- altera o nome do campo
ALTER TABLE `jos_ejoomla_v0020` CHANGE `requerido_0020` `null` BIT( 1 ) NULL DEFAULT NULL ;

-- adiciona o campo valor de
ALTER TABLE `jos_edesktop_produtos_produtos` ADD `valorde` DECIMAL( 10, 2 ) NOT NULL AFTER `valor`;

-- 
