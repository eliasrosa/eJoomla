-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- REQUERIDO 0012

ALTER TABLE `versao_db` CHANGE `requerido_0012` `requerido_0013` BIT(1) NULL DEFAULT NULL;



-- inseri a tabela de pedidos
CREATE TABLE `jos_edesktop_loja_pedidos` (
	`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`VendedorEmail` VARCHAR( 255 ) NOT NULL ,
	`TransacaoID` VARCHAR( 32 ) NOT NULL ,
	`Extras` DECIMAL( 10, 2 ) NOT NULL ,
	`TipoFrete` VARCHAR( 50 ) NOT NULL ,
	`ValorFrete` DECIMAL( 10, 2 ) NOT NULL ,
	`ValorDesconto` DECIMAL( 10, 2 ) NOT NULL ,
	`CupomID` INT(11) NOT NULL ,
	`Anotacao` VARCHAR( 255 ) NOT NULL ,
	`DataTransacao` DATETIME NOT NULL ,
	`TipoPagamento` VARCHAR( 30 ) NOT NULL ,
	`StatusTransacao` VARCHAR( 30 ) NOT NULL ,
	`CliNome` VARCHAR( 100 ) NOT NULL ,
	`CliEmail` VARCHAR( 255 ) NOT NULL ,
	`CliEndereco` VARCHAR( 200 ) NOT NULL ,
	`CliNumero` VARCHAR( 10 ) NOT NULL ,
	`CliComplemento` VARCHAR( 100 ) NOT NULL ,
	`CliBairro` VARCHAR( 100 ) NOT NULL ,
	`CliCidade` VARCHAR( 100 ) NOT NULL ,
	`CliEstado` VARCHAR( 2 ) NOT NULL ,
	`CliCEP` VARCHAR( 10 ) NOT NULL ,
	`CliTelefone` VARCHAR( 16 ) NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;



-- inseri a tabela de itens de pedidos
CREATE TABLE `jos_edesktop_loja_pedidos_itens` (
	`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`idPedido` INT( 11 ) NOT NULL ,
	`nome` VARCHAR( 255 ) NOT NULL ,
	`valorOriginal` DECIMAL( 10,2 ) NOT NULL ,
	`valor` DECIMAL( 10,2 ) NOT NULL ,
	`quantidade` INT( 11 ) NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;


-- adiciona config do token do pagseguro
INSERT INTO `jos_edesktop_loja_configuracoes` (`var`, `value`, `comentario`) VALUES ('pagSeguroToken', '', 'Token de retorno do pagSeguro');

-- atualizado a config de e-mail de cobrança do pagseguro
UPDATE `jos_edesktop_loja_configuracoes` SET `value` = '', `comentario` = 'E-mail de cobrança do PagSeguro' WHERE `var` = 'pagSeguroEmailCobranca' LIMIT 1;

