-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- REQUERIDO 0014

ALTER TABLE `versao_db` CHANGE `requerido_0014` `requerido_0015` BIT(1) NULL DEFAULT NULL;

-- adiciona ordem nas categorias
ALTER TABLE `jos_edesktop_produtos_categorias`  ADD `ordem` int(11) NOT NULL AFTER `status`;

