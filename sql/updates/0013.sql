-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- REQUERIDO 0013

ALTER TABLE `versao_db` CHANGE `requerido_0013` `requerido_0014` BIT(1) NULL DEFAULT NULL;

-- adiciona opcoes
ALTER TABLE `jos_edesktop_produtos_produtos`  ADD `opcoes` LONGTEXT NOT NULL AFTER `referencia`;