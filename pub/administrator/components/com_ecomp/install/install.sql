--
-- Estrutura da tabela `jos_ecomp_cadastros`
--

CREATE TABLE IF NOT EXISTS `#__ecomp_cadastros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcomponente` int(11) NOT NULL,
  `idcategoria` int(11) NOT NULL,
  `dados` longtext NOT NULL,
  `ordering` int(11) NOT NULL,
  `trashed` tinyint(1) NOT NULL DEFAULT '0',
  `published` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_ecomp_campos`
--

CREATE TABLE IF NOT EXISTS `#__ecomp_campos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcomponente` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `label` varchar(100) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `ordering` int(11) NOT NULL,
  `published` int(11) NOT NULL,
  `trashed` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_ecomp_categorias`
--

CREATE TABLE IF NOT EXISTS `#__ecomp_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idpai` int(11) NOT NULL DEFAULT '0',
  `idcomponente` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `published` int(11) NOT NULL,
  `trashed` int(11) NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_ecomp_componentes`
--

CREATE TABLE IF NOT EXISTS `#__ecomp_componentes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idMenuAdmin` int(11) NOT NULL DEFAULT '0',
  `nome` varchar(100) NOT NULL,
  `published` int(11) NOT NULL,
  `trashed` int(11) NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;
