
-- REQUERIDO 0001

ALTER TABLE `versao_db` CHANGE `requerido_0001` `requerido_0002` BIT(1) NULL DEFAULT NULL;

--
-- Estrutura da tabela `jos_ecomp_routers_cache`
--

CREATE TABLE IF NOT EXISTS `jos_ecomp_routers_cache` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemid` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `params` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_ecomp_routers_rules`
--

CREATE TABLE IF NOT EXISTS `jos_ecomp_routers_rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemid` int(11) NOT NULL,
  `ordering` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `get_var` varchar(255) NOT NULL,
  `get_value` varchar(255) NOT NULL,
  `alias1` varchar(255) NOT NULL,
  `alias2` varchar(255) NOT NULL,
  `published` int(11) NOT NULL,
  `trashed` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

