-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- REQUERIDO 0010

ALTER TABLE `versao_db` CHANGE `requerido_0010` `requerido_0011` BIT(1) NULL DEFAULT NULL;



-- adiciona a coluna descricao no produto
ALTER TABLE `jos_edesktop_produtos_produtos`  ADD `descricao` LONGTEXT NOT NULL AFTER `peso`;



-- adiciona a tabela de textos
CREATE TABLE `jos_edesktop_produtos_textos` (
	`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`idproduto` INT(11) NOT NULL,
	`titulo` VARCHAR(255) NOT NULL,
	`html` LONGTEXT NOT NULL,
	`ordem` INT(11) NOT NULL,
	`status` INT(1) NOT NULL
) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;




-- adiciona tabela de configuracoes da loja
CREATE TABLE `jos_edesktop_loja_configuracoes` (
	`var` VARCHAR(255) NOT NULL,
	`value` LONGTEXT NOT NULL,
	`comentario` LONGTEXT NOT NULL,
	UNIQUE (`var`)
) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;




-- inserir configurações da loja
INSERT INTO `jos_edesktop_loja_configuracoes` (`var`, `value`, `comentario`) VALUES ('freteCepOrigem', '00000-000', 'Cep de origem para consultas de envio');
INSERT INTO `jos_edesktop_loja_configuracoes` (`var`, `value`, `comentario`) VALUES ('freteTipo', 'fixo', 'Tipo de frete');
INSERT INTO `jos_edesktop_loja_configuracoes` (`var`, `value`, `comentario`) VALUES ('freteValor', '10.00', 'Valor do frete fixo');
INSERT INTO `jos_edesktop_loja_configuracoes` (`var`, `value`, `comentario`) VALUES ('produtosPorPagina', '12', 'Número de produtos nas listagens');



-- adiciona campo frete na tabela de produtos
ALTER TABLE `jos_edesktop_produtos_produtos`  ADD `frete` FLOAT NOT NULL AFTER `peso`;



-- adicionado a tabela de cupons da loja
CREATE TABLE `jos_edesktop_loja_cupons` (
	`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`codigo` VARCHAR( 20 ) NOT NULL ,
	`valor` FLOAT NOT NULL ,
	`tipo` VARCHAR( 1 ) NOT NULL ,
	`vencimento` DATE NOT NULL ,
	`quantidade` INT( 11 ) NOT NULL ,
	`observacoes` LONGTEXT NOT NULL ,
	`status` INT( 1 ) NOT NULL
) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;



