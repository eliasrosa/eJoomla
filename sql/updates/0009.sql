-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- REQUERIDO 0009

ALTER TABLE `versao_db` CHANGE `requerido_0009` `requerido_0010` BIT(1) NULL DEFAULT NULL;




-- adiciona o componente edesktop
INSERT INTO jos_components 
	( `name`, `link`, `admin_menu_link`, `admin_menu_alt`, `option`, `admin_menu_img`, `params`, `enabled`)
VALUES 
	('eDesktop','option=com_edesktop','option=com_edesktop','eDesktop', 'com_edesktop','js/ThemeOffice/component.png','', 1);




-- adiciona a tabela de produtos
CREATE TABLE `jos_edesktop_produtos_produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idfabricante` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `valor` float NOT NULL,
  `peso` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `referencia` varchar(255) NOT NULL,
  `metatagkey` varchar(255) NOT NULL,
  `metatagdescription` varchar(160) NOT NULL,
  `destaque` int(1) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;




-- adiciona a tabela categorias
CREATE TABLE `jos_edesktop_produtos_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idpai` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;




-- adiciona a tabela de relacionamento de produtos e categorias
CREATE TABLE `jos_edesktop_produtos_categorias_rel` (
  `idproduto` int(11) NOT NULL,
  `idcategoria` int(11) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;




-- adiciona a tabela de fabricantes
CREATE TABLE `jos_edesktop_produtos_fabricantes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `descricao` longtext NOT NULL,
  `logotipo` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;




-- adiciona a tabela de imagens
CREATE TABLE `jos_edesktop_produtos_imagens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idproduto` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `destaque` int(1) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- corrigido charset de alguma tabelas
ALTER TABLE `jos_ecomp_usuarios` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `versao_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `jos_ecomp_routers_cache` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `jos_ecomp_routers_cache` CHANGE `url` `url` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `params` `params` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `jos_ecomp_routers_rules` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `jos_ecomp_routers_rules` CHANGE `type` `type` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `get_var` `get_var` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `get_value` `get_value` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `alias1` `alias1` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `alias2` `alias2` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

