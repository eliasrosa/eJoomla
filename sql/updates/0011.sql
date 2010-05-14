-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- REQUERIDO 0011

ALTER TABLE `versao_db` CHANGE `requerido_0011` `requerido_0012` BIT(1) NULL DEFAULT NULL;


-- alterado o valores para decimal dos produtos
ALTER TABLE `jos_edesktop_produtos_produtos` 
	CHANGE `valor` `valor` DECIMAL(10,2) NOT NULL,
	CHANGE `frete` `frete` DECIMAL(10,2) NOT NULL;


-- alterado o valores para decimal dos cupons
ALTER TABLE `jos_edesktop_loja_cupons` 
	CHANGE `valor` `valor` DECIMAL(10,2) NOT NULL;
	
	
-- inseri a config do e-mail de cobrança
INSERT INTO `jos_edesktop_loja_configuracoes` 
	(`var`, `value`, `comentario`) VALUES ('pagSeguroEmailCobranca', 'elias@eliasdarosa.com.br', 'E-mail de combrança do PagSeguro');
	

