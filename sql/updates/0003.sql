-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- REQUERIDO 0003

ALTER TABLE `versao_db` CHANGE `requerido_0003` `requerido_0004` BIT(1) NULL DEFAULT NULL;

ALTER TABLE `jos_ecomp_routers_rules`  ADD `idcomponente` INT(11) NOT NULL AFTER `itemid`;
