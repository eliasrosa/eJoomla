-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- REQUERIDO 0006

ALTER TABLE `versao_db` CHANGE `requerido_0006` `requerido_0007` BIT(1) NULL DEFAULT NULL;

CREATE TABLE IF NOT EXISTS `jos_edesktop_usuarios_grupos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `permissoes` longtext NOT NULL,
  `descricao` longtext NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `jos_edesktop_usuarios_grupos`
--

INSERT INTO `jos_edesktop_usuarios_grupos` (`id`, `nome`, `permissoes`, `descricao`, `status`) VALUES
(1, 'Administradores', '', '', 1);
