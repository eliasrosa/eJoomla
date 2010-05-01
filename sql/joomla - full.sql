-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Nov 27, 2009 as 06:12 PM
-- Versão do Servidor: 5.1.33
-- Versão do PHP: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Banco de Dados: `ejoomla`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_banner`
--

CREATE TABLE IF NOT EXISTS `jos_banner` (
  `bid` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0',
  `type` varchar(30) NOT NULL DEFAULT 'banner',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `imptotal` int(11) NOT NULL DEFAULT '0',
  `impmade` int(11) NOT NULL DEFAULT '0',
  `clicks` int(11) NOT NULL DEFAULT '0',
  `imageurl` varchar(100) NOT NULL DEFAULT '',
  `clickurl` varchar(200) NOT NULL DEFAULT '',
  `date` datetime DEFAULT NULL,
  `showBanner` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `editor` varchar(50) DEFAULT NULL,
  `custombannercode` text,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `sticky` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tags` text NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`bid`),
  KEY `viewbanner` (`showBanner`),
  KEY `idx_banner_catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_banner`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_bannerclient`
--

CREATE TABLE IF NOT EXISTS `jos_bannerclient` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `contact` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `extrainfo` text NOT NULL,
  `checked_out` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out_time` time DEFAULT NULL,
  `editor` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_bannerclient`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_bannertrack`
--

CREATE TABLE IF NOT EXISTS `jos_bannertrack` (
  `track_date` date NOT NULL,
  `track_type` int(10) unsigned NOT NULL,
  `banner_id` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `jos_bannertrack`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_categories`
--

CREATE TABLE IF NOT EXISTS `jos_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `section` varchar(50) NOT NULL DEFAULT '',
  `image_position` varchar(30) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `editor` varchar(50) DEFAULT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_idx` (`section`,`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_categories`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_components`
--

CREATE TABLE IF NOT EXISTS `jos_components` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `link` varchar(255) NOT NULL DEFAULT '',
  `menuid` int(11) unsigned NOT NULL DEFAULT '0',
  `parent` int(11) unsigned NOT NULL DEFAULT '0',
  `admin_menu_link` varchar(255) NOT NULL DEFAULT '',
  `admin_menu_alt` varchar(255) NOT NULL DEFAULT '',
  `option` varchar(50) NOT NULL DEFAULT '',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `admin_menu_img` varchar(255) NOT NULL DEFAULT '',
  `iscore` tinyint(4) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `enabled` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `parent_option` (`parent`,`option`(32))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=69 ;

--
-- Extraindo dados da tabela `jos_components`
--

INSERT INTO `jos_components` (`id`, `name`, `link`, `menuid`, `parent`, `admin_menu_link`, `admin_menu_alt`, `option`, `ordering`, `admin_menu_img`, `iscore`, `params`, `enabled`) VALUES
(1, 'Banners', '', 0, 0, '', 'Banner Management', 'com_banners', 0, 'js/ThemeOffice/component.png', 0, 'track_impressions=0\ntrack_clicks=0\ntag_prefix=\n\n', 1),
(2, 'Banners', '', 0, 1, 'option=com_banners', 'Active Banners', 'com_banners', 1, 'js/ThemeOffice/edit.png', 0, '', 1),
(3, 'Clients', '', 0, 1, 'option=com_banners&c=client', 'Manage Clients', 'com_banners', 2, 'js/ThemeOffice/categories.png', 0, '', 1),
(4, 'Web Links', 'option=com_weblinks', 0, 0, '', 'Manage Weblinks', 'com_weblinks', 0, 'js/ThemeOffice/component.png', 0, 'show_comp_description=1\ncomp_description=\nshow_link_hits=1\nshow_link_description=1\nshow_other_cats=1\nshow_headings=1\nshow_page_title=1\nlink_target=0\nlink_icons=\n\n', 1),
(5, 'Links', '', 0, 4, 'option=com_weblinks', 'View existing weblinks', 'com_weblinks', 1, 'js/ThemeOffice/edit.png', 0, '', 1),
(6, 'Categories', '', 0, 4, 'option=com_categories&section=com_weblinks', 'Manage weblink categories', '', 2, 'js/ThemeOffice/categories.png', 0, '', 1),
(7, 'Contacts', 'option=com_contact', 0, 0, '', 'Edit contact details', 'com_contact', 0, 'js/ThemeOffice/component.png', 1, 'contact_icons=0\nicon_address=\nicon_email=\nicon_telephone=\nicon_fax=\nicon_misc=\nshow_headings=1\nshow_position=1\nshow_email=0\nshow_telephone=1\nshow_mobile=1\nshow_fax=1\nbannedEmail=\nbannedSubject=\nbannedText=\nsession=1\ncustomReply=0\n\n', 1),
(8, 'Contacts', '', 0, 7, 'option=com_contact', 'Edit contact details', 'com_contact', 0, 'js/ThemeOffice/edit.png', 1, '', 1),
(9, 'Categories', '', 0, 7, 'option=com_categories&section=com_contact_details', 'Manage contact categories', '', 2, 'js/ThemeOffice/categories.png', 1, 'contact_icons=0\nicon_address=\nicon_email=\nicon_telephone=\nicon_fax=\nicon_misc=\nshow_headings=1\nshow_position=1\nshow_email=0\nshow_telephone=1\nshow_mobile=1\nshow_fax=1\nbannedEmail=\nbannedSubject=\nbannedText=\nsession=1\ncustomReply=0\n\n', 1),
(10, 'Polls', 'option=com_poll', 0, 0, 'option=com_poll', 'Manage Polls', 'com_poll', 0, 'js/ThemeOffice/component.png', 0, '', 1),
(11, 'News Feeds', 'option=com_newsfeeds', 0, 0, '', 'News Feeds Management', 'com_newsfeeds', 0, 'js/ThemeOffice/component.png', 0, '', 1),
(12, 'Feeds', '', 0, 11, 'option=com_newsfeeds', 'Manage News Feeds', 'com_newsfeeds', 1, 'js/ThemeOffice/edit.png', 0, 'show_headings=1\nshow_name=1\nshow_articles=1\nshow_link=1\nshow_cat_description=1\nshow_cat_items=1\nshow_feed_image=1\nshow_feed_description=1\nshow_item_description=1\nfeed_word_count=0\n\n', 1),
(13, 'Categories', '', 0, 11, 'option=com_categories&section=com_newsfeeds', 'Manage Categories', '', 2, 'js/ThemeOffice/categories.png', 0, '', 1),
(14, 'User', 'option=com_user', 0, 0, '', '', 'com_user', 0, '', 1, '', 1),
(15, 'Search', 'option=com_search', 0, 0, 'option=com_search', 'Search Statistics', 'com_search', 0, 'js/ThemeOffice/component.png', 1, 'enabled=0\n\n', 1),
(16, 'Categories', '', 0, 1, 'option=com_categories&section=com_banner', 'Categories', '', 3, '', 1, '', 1),
(17, 'Wrapper', 'option=com_wrapper', 0, 0, '', 'Wrapper', 'com_wrapper', 0, '', 1, '', 1),
(18, 'Mail To', '', 0, 0, '', '', 'com_mailto', 0, '', 1, '', 1),
(19, 'Media Manager', '', 0, 0, 'option=com_media', 'Media Manager', 'com_media', 0, '', 1, 'upload_extensions=bmp,csv,doc,epg,gif,ico,jpg,odg,odp,ods,odt,pdf,png,ppt,swf,txt,xcf,xls,BMP,CSV,DOC,EPG,GIF,ICO,JPG,ODG,ODP,ODS,ODT,PDF,PNG,PPT,SWF,TXT,XCF,XLS\nupload_maxsize=10000000\nfile_path=images\nimage_path=images/stories\nrestrict_uploads=1\nallowed_media_usergroup=3\ncheck_mime=1\nimage_extensions=bmp,gif,jpg,png\nignore_extensions=\nupload_mime=image/jpeg,image/gif,image/png,image/bmp,application/x-shockwave-flash,application/msword,application/excel,application/pdf,application/powerpoint,text/plain,application/x-zip\nupload_mime_illegal=text/html\nenable_flash=0\n\n', 1),
(20, 'Articles', 'option=com_content', 0, 0, '', '', 'com_content', 0, '', 1, 'show_noauth=0\nshow_title=1\nlink_titles=0\nshow_intro=1\nshow_section=0\nlink_section=0\nshow_category=0\nlink_category=0\nshow_author=1\nshow_create_date=1\nshow_modify_date=1\nshow_item_navigation=0\nshow_readmore=1\nshow_vote=0\nshow_icons=1\nshow_pdf_icon=1\nshow_print_icon=1\nshow_email_icon=1\nshow_hits=1\nfeed_summary=0\n\n', 1),
(21, 'Configuration Manager', '', 0, 0, '', 'Configuration', 'com_config', 0, '', 1, '', 1),
(22, 'Installation Manager', '', 0, 0, '', 'Installer', 'com_installer', 0, '', 1, '', 1),
(23, 'Language Manager', '', 0, 0, '', 'Languages', 'com_languages', 0, '', 1, 'administrator=pt-BR\nsite=pt-BR', 1),
(24, 'Mass mail', '', 0, 0, '', 'Mass Mail', 'com_massmail', 0, '', 1, 'mailSubjectPrefix=\nmailBodySuffix=\n\n', 1),
(25, 'Menu Editor', '', 0, 0, '', 'Menu Editor', 'com_menus', 0, '', 1, '', 1),
(27, 'Messaging', '', 0, 0, '', 'Messages', 'com_messages', 0, '', 1, '', 1),
(28, 'Modules Manager', '', 0, 0, '', 'Modules', 'com_modules', 0, '', 1, '', 1),
(29, 'Plugin Manager', '', 0, 0, '', 'Plugins', 'com_plugins', 0, '', 1, '', 1),
(30, 'Template Manager', '', 0, 0, '', 'Templates', 'com_templates', 0, '', 1, '', 1),
(31, 'User Manager', '', 0, 0, '', 'Users', 'com_users', 0, '', 1, 'allowUserRegistration=1\nnew_usertype=Registered\nuseractivation=1\nfrontend_userparams=1\n\n', 1),
(32, 'Cache Manager', '', 0, 0, '', 'Cache', 'com_cache', 0, '', 1, '', 1),
(33, 'Control Panel', '', 0, 0, '', 'Control Panel', 'com_cpanel', 0, '', 1, '', 1),
(44, 'eFormMail', 'option=com_eformmail', 0, 0, 'option=com_eformmail', 'eFormMail', 'com_eformmail', 0, 'js/ThemeOffice/component.png', 0, '', 1),
(35, 'JCE', 'option=com_jce', 0, 0, 'option=com_jce', 'JCE', 'com_jce', 0, 'components/com_jce/img/logo.png', 0, '\npackage=1', 1),
(36, 'JCE MENU CPANEL', '', 0, 35, 'option=com_jce', 'JCE MENU CPANEL', 'com_jce', 0, 'templates/khepri/images/menu/icon-16-cpanel.png', 0, '', 1),
(37, 'JCE MENU CONFIG', '', 0, 35, 'option=com_jce&type=config', 'JCE MENU CONFIG', 'com_jce', 1, 'templates/khepri/images/menu/icon-16-config.png', 0, '', 1),
(38, 'JCE MENU GROUPS', '', 0, 35, 'option=com_jce&type=group', 'JCE MENU GROUPS', 'com_jce', 2, 'templates/khepri/images/menu/icon-16-user.png', 0, '', 1),
(39, 'JCE MENU PLUGINS', '', 0, 35, 'option=com_jce&type=plugin', 'JCE MENU PLUGINS', 'com_jce', 3, 'templates/khepri/images/menu/icon-16-plugin.png', 0, '', 1),
(40, 'JCE MENU INSTALL', '', 0, 35, 'option=com_jce&type=install', 'JCE MENU INSTALL', 'com_jce', 4, 'templates/khepri/images/menu/icon-16-install.png', 0, '', 1),
(41, 'eComp', 'option=com_ecomp', 0, 0, 'option=com_ecomp', 'eComp', 'com_ecomp', 0, 'js/ThemeOffice/component.png', 0, '', 1),
(42, 'Componentes', '', 0, 41, 'option=com_ecomp&view=componentes', 'Componentes', 'com_ecomp', 0, '', 0, '', 1),
(43, 'Campos', '', 0, 41, 'option=com_ecomp&view=campos', 'Campos', 'com_ecomp', 1, '', 0, '', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_contact_details`
--

CREATE TABLE IF NOT EXISTS `jos_contact_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `con_position` varchar(255) DEFAULT NULL,
  `address` text,
  `suburb` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `postcode` varchar(100) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `misc` mediumtext,
  `image` varchar(255) DEFAULT NULL,
  `imagepos` varchar(20) DEFAULT NULL,
  `email_to` varchar(255) DEFAULT NULL,
  `default_con` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `catid` int(11) NOT NULL DEFAULT '0',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `mobile` varchar(255) NOT NULL DEFAULT '',
  `webpage` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_contact_details`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_content`
--

CREATE TABLE IF NOT EXISTS `jos_content` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `title_alias` varchar(255) NOT NULL DEFAULT '',
  `introtext` mediumtext NOT NULL,
  `fulltext` mediumtext NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `sectionid` int(11) unsigned NOT NULL DEFAULT '0',
  `mask` int(11) unsigned NOT NULL DEFAULT '0',
  `catid` int(11) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `images` text NOT NULL,
  `urls` text NOT NULL,
  `attribs` text NOT NULL,
  `version` int(11) unsigned NOT NULL DEFAULT '1',
  `parentid` int(11) unsigned NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `access` int(11) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `metadata` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_section` (`sectionid`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_content`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_content_frontpage`
--

CREATE TABLE IF NOT EXISTS `jos_content_frontpage` (
  `content_id` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `jos_content_frontpage`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_content_rating`
--

CREATE TABLE IF NOT EXISTS `jos_content_rating` (
  `content_id` int(11) NOT NULL DEFAULT '0',
  `rating_sum` int(11) unsigned NOT NULL DEFAULT '0',
  `rating_count` int(11) unsigned NOT NULL DEFAULT '0',
  `lastip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `jos_content_rating`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_core_acl_aro`
--

CREATE TABLE IF NOT EXISTS `jos_core_acl_aro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_value` varchar(240) NOT NULL DEFAULT '0',
  `value` varchar(240) NOT NULL DEFAULT '',
  `order_value` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `hidden` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `jos_section_value_value_aro` (`section_value`(100),`value`(100)),
  KEY `jos_gacl_hidden_aro` (`hidden`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Extraindo dados da tabela `jos_core_acl_aro`
--

INSERT INTO `jos_core_acl_aro` (`id`, `section_value`, `value`, `order_value`, `name`, `hidden`) VALUES
(10, 'users', '62', 0, 'Administrator', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_core_acl_aro_groups`
--

CREATE TABLE IF NOT EXISTS `jos_core_acl_aro_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `lft` int(11) NOT NULL DEFAULT '0',
  `rgt` int(11) NOT NULL DEFAULT '0',
  `value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `jos_gacl_parent_id_aro_groups` (`parent_id`),
  KEY `jos_gacl_lft_rgt_aro_groups` (`lft`,`rgt`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Extraindo dados da tabela `jos_core_acl_aro_groups`
--

INSERT INTO `jos_core_acl_aro_groups` (`id`, `parent_id`, `name`, `lft`, `rgt`, `value`) VALUES
(17, 0, 'ROOT', 1, 22, 'ROOT'),
(28, 17, 'USERS', 2, 21, 'USERS'),
(29, 28, 'Public Frontend', 3, 12, 'Public Frontend'),
(18, 29, 'Registered', 4, 11, 'Registered'),
(19, 18, 'Author', 5, 10, 'Author'),
(20, 19, 'Editor', 6, 9, 'Editor'),
(21, 20, 'Publisher', 7, 8, 'Publisher'),
(30, 28, 'Public Backend', 13, 20, 'Public Backend'),
(23, 30, 'Manager', 14, 19, 'Manager'),
(24, 23, 'Administrator', 15, 18, 'Administrator'),
(25, 24, 'Super Administrator', 16, 17, 'Super Administrator');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_core_acl_aro_map`
--

CREATE TABLE IF NOT EXISTS `jos_core_acl_aro_map` (
  `acl_id` int(11) NOT NULL DEFAULT '0',
  `section_value` varchar(230) NOT NULL DEFAULT '0',
  `value` varchar(100) NOT NULL,
  PRIMARY KEY (`acl_id`,`section_value`,`value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `jos_core_acl_aro_map`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_core_acl_aro_sections`
--

CREATE TABLE IF NOT EXISTS `jos_core_acl_aro_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(230) NOT NULL DEFAULT '',
  `order_value` int(11) NOT NULL DEFAULT '0',
  `name` varchar(230) NOT NULL DEFAULT '',
  `hidden` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `jos_gacl_value_aro_sections` (`value`),
  KEY `jos_gacl_hidden_aro_sections` (`hidden`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Extraindo dados da tabela `jos_core_acl_aro_sections`
--

INSERT INTO `jos_core_acl_aro_sections` (`id`, `value`, `order_value`, `name`, `hidden`) VALUES
(10, 'users', 1, 'Users', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_core_acl_groups_aro_map`
--

CREATE TABLE IF NOT EXISTS `jos_core_acl_groups_aro_map` (
  `group_id` int(11) NOT NULL DEFAULT '0',
  `section_value` varchar(240) NOT NULL DEFAULT '',
  `aro_id` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `group_id_aro_id_groups_aro_map` (`group_id`,`section_value`,`aro_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `jos_core_acl_groups_aro_map`
--

INSERT INTO `jos_core_acl_groups_aro_map` (`group_id`, `section_value`, `aro_id`) VALUES
(25, '', 10);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_core_log_items`
--

CREATE TABLE IF NOT EXISTS `jos_core_log_items` (
  `time_stamp` date NOT NULL DEFAULT '0000-00-00',
  `item_table` varchar(50) NOT NULL DEFAULT '',
  `item_id` int(11) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `jos_core_log_items`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_core_log_searches`
--

CREATE TABLE IF NOT EXISTS `jos_core_log_searches` (
  `search_term` varchar(128) NOT NULL DEFAULT '',
  `hits` int(11) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `jos_core_log_searches`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_ecomp_cadastros_categorias`
--

CREATE TABLE IF NOT EXISTS `jos_ecomp_cadastros_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcomponente` int(11) NOT NULL,
  `idcadastro` int(11) NOT NULL,
  `idcategoria` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_ecomp_cadastros_categorias`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_ecomp_cadastros_imagens`
--

CREATE TABLE IF NOT EXISTS `jos_ecomp_cadastros_imagens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcadastro` int(11) NOT NULL,
  `idcomponente` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `legenda` varchar(255) NOT NULL,
  `descricao` longtext NOT NULL,
  `resumo` longtext NOT NULL,
  `grupo` int(11) NOT NULL,
  `published` int(11) NOT NULL,
  `trashed` int(11) NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_ecomp_cadastros_imagens`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_ecomp_cadastros_tags`
--

CREATE TABLE IF NOT EXISTS `jos_ecomp_cadastros_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcomponente` int(11) NOT NULL,
  `idcadastro` int(11) NOT NULL,
  `idtag` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_ecomp_cadastros_tags`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_ecomp_campos`
--

CREATE TABLE IF NOT EXISTS `jos_ecomp_campos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcomponente` int(11) NOT NULL,
  `idtipo` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `params` longtext NOT NULL,
  `ordering` int(11) NOT NULL,
  `published` int(11) NOT NULL,
  `trashed` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_ecomp_campos`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_ecomp_campos_tipos`
--

CREATE TABLE IF NOT EXISTS `jos_ecomp_campos_tipos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) CHARACTER SET latin1 NOT NULL,
  `code` longtext CHARACTER SET latin1 NOT NULL,
  `params` longtext CHARACTER SET latin1 NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Extraindo dados da tabela `jos_ecomp_campos_tipos`
--

INSERT INTO `jos_ecomp_campos_tipos` (`id`, `nome`, `code`, `params`) VALUES
(1, 'Texto simples', 'varchar(255) NOT NULL COMMENT ''Texto simples''', 'maxlength=255&size=100&value='),
(2, 'Texto longo', 'longtext NOT NULL COMMENT ''Texto longo''', 'cols=57&rows=3&value='),
(3, 'HTML', 'longtext NOT NULL COMMENT ''HTML''', 'width=417&height=350'),
(4, 'Upload', 'varchar(255) NOT NULL COMMENT ''Upload''', ''),
(5, 'Boolean', 'int(11) NOT NULL COMMENT ''Boolean''', ''),
(6, 'Data', 'date NOT NULL COMMENT ''Data''', ''),
(7, 'Data/Hora', 'datetime NOT NULL COMMENT ''Data/Hora''', ''),
(8, 'Relacionamento entre componentes', 'int(11) NOT NULL COMMENT ''Relacionamento entre componente''', 'idcomponente=0&idcampo=0'),
(9, 'Imagens da galeria', 'int(11) NOT NULL COMMENT ''Imagens da galeria''', 'idcomponente=0&idcadastro=0'),
(10, 'Combo simples', 'varchar(255) NOT NULL COMMENT ''Select''', 'itens=1;Um|2;Dois|3;Três'),
(11, 'Upload de imagem', 'varchar(255) NOT NULL COMMENT ''Upload de imagem''', 'width=1024&height=1024&fit=inside&scale=down&ext=jpg;png;gif&resize_gif=1&resize=1'),
(12, 'Número inteiro', 'int(11) NOT NULL COMMENT ''Número inteiro''', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_ecomp_categorias`
--

CREATE TABLE IF NOT EXISTS `jos_ecomp_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idpai` int(11) NOT NULL DEFAULT '0',
  `idcomponente` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `published` int(11) NOT NULL,
  `trashed` int(11) NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_ecomp_categorias`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_ecomp_componentes`
--

CREATE TABLE IF NOT EXISTS `jos_ecomp_componentes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idMenuAdmin` int(11) NOT NULL DEFAULT '0',
  `nome` varchar(100) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `exibir_manager` int(11) NOT NULL,
  `published` int(11) NOT NULL,
  `trashed` int(11) NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_ecomp_componentes`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_ecomp_tags`
--

CREATE TABLE IF NOT EXISTS `jos_ecomp_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idpai` int(11) NOT NULL DEFAULT '0',
  `idcomponente` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `published` int(11) NOT NULL,
  `trashed` int(11) NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_ecomp_tags`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_ecomp_usuarios`
--

CREATE TABLE IF NOT EXISTS `jos_ecomp_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `usuario` varchar(50) CHARACTER SET utf8 NOT NULL,
  `senha` varchar(40) CHARACTER SET utf8 NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_ecomp_usuarios`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_eformmail_formularios`
--

CREATE TABLE IF NOT EXISTS `jos_eformmail_formularios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `to` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `replyto` varchar(255) NOT NULL,
  `from` varchar(255) NOT NULL,
  `cc` varchar(255) NOT NULL,
  `co` varchar(255) NOT NULL,
  `charset` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `form` longtext NOT NULL,
  `published` tinyint(1) NOT NULL,
  `trashed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_eformmail_formularios`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_groups`
--

CREATE TABLE IF NOT EXISTS `jos_groups` (
  `id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `jos_groups`
--

INSERT INTO `jos_groups` (`id`, `name`) VALUES
(0, 'Public'),
(1, 'Registered'),
(2, 'Special');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_jce_extensions`
--

CREATE TABLE IF NOT EXISTS `jos_jce_extensions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `extension` varchar(255) NOT NULL,
  `folder` varchar(255) NOT NULL,
  `published` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `jos_jce_extensions`
--

INSERT INTO `jos_jce_extensions` (`id`, `pid`, `name`, `extension`, `folder`, `published`) VALUES
(1, 54, 'Joomla Links for Advanced Link', 'joomlalinks', 'links', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_jce_groups`
--

CREATE TABLE IF NOT EXISTS `jos_jce_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `users` text NOT NULL,
  `types` varchar(255) NOT NULL,
  `components` text NOT NULL,
  `rows` text NOT NULL,
  `plugins` varchar(255) NOT NULL,
  `published` tinyint(3) NOT NULL,
  `ordering` int(11) NOT NULL,
  `checked_out` tinyint(3) NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `jos_jce_groups`
--

INSERT INTO `jos_jce_groups` (`id`, `name`, `description`, `users`, `types`, `components`, `rows`, `plugins`, `published`, `ordering`, `checked_out`, `checked_out_time`, `params`) VALUES
(1, 'Default', 'Default group for all users with edit access', '', '19,20,21,23,24,25', '', '6,7,8,9,10,11,12,13,14,15,16,17,18,19;20,21,22,23,24,25,26,27,28,30,31,32,33,36;37,38,39,40,41,42,43,44,45,46,47,48;49,50,51,52,53,54,55,57,58', '1,2,3,4,5,6,20,21,37,38,39,40,41,42,49,50,51,52,53,54,55,57,58', 1, 1, 0, '0000-00-00 00:00:00', ''),
(2, 'Front End', 'Sample Group for Authors, Editors, Publishers', '', '19,20,21', '', '6,7,8,9,10,13,14,15,16,17,18,19,27,28;20,21,25,26,30,31,32,36,43,44,45,47,48,50,51;24,33,39,40,42,46,49,52,53,54,55,57,58', '6,20,21,50,51,1,3,5,39,40,42,49,52,53,54,55,57,58', 0, 2, 0, '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_jce_plugins`
--

CREATE TABLE IF NOT EXISTS `jos_jce_plugins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `layout` varchar(255) NOT NULL,
  `row` int(11) NOT NULL,
  `ordering` int(11) NOT NULL,
  `published` tinyint(3) NOT NULL,
  `editable` tinyint(3) NOT NULL,
  `iscore` tinyint(3) NOT NULL,
  `elements` varchar(255) NOT NULL,
  `checked_out` int(11) NOT NULL,
  `checked_out_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `plugin` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=59 ;

--
-- Extraindo dados da tabela `jos_jce_plugins`
--

INSERT INTO `jos_jce_plugins` (`id`, `title`, `name`, `type`, `icon`, `layout`, `row`, `ordering`, `published`, `editable`, `iscore`, `elements`, `checked_out`, `checked_out_time`) VALUES
(1, 'Context Menu', 'contextmenu', 'plugin', '', '', 0, 0, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(2, 'File Browser', 'browser', 'plugin', '', '', 0, 0, 1, 1, 1, '', 0, '0000-00-00 00:00:00'),
(3, 'Inline Popups', 'inlinepopups', 'plugin', '', '', 0, 0, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(4, 'Media Support', 'media', 'plugin', '', '', 0, 0, 1, 1, 1, '', 0, '0000-00-00 00:00:00'),
(5, 'Safari Browser Support', 'safari', 'plugin', '', '', 0, 0, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(6, 'Help', 'help', 'plugin', 'help', 'help', 1, 1, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(7, 'New Document', 'newdocument', 'command', 'newdocument', 'newdocument', 1, 2, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(8, 'Bold', 'bold', 'command', 'bold', 'bold', 1, 3, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(9, 'Italic', 'italic', 'command', 'italic', 'italic', 1, 4, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(10, 'Underline', 'underline', 'command', 'underline', 'underline', 1, 5, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(11, 'Font Select', 'fontselect', 'command', 'fontselect', 'fontselect', 1, 6, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(12, 'Font Size Select', 'fontsizeselect', 'command', 'fontsizeselect', 'fontsizeselect', 1, 7, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(13, 'Style Select', 'styleselect', 'command', 'styleselect', 'styleselect', 1, 8, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(14, 'StrikeThrough', 'strikethrough', 'command', 'strikethrough', 'strikethrough', 1, 9, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(15, 'Justify Full', 'full', 'command', 'justifyfull', 'justifyfull', 1, 10, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(16, 'Justify Center', 'center', 'command', 'justifycenter', 'justifycenter', 1, 11, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(17, 'Justify Left', 'left', 'command', 'justifyleft', 'justifyleft', 1, 12, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(18, 'Justify Right', 'right', 'command', 'justifyright', 'justifyright', 1, 13, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(19, 'Format Select', 'formatselect', 'command', 'formatselect', 'formatselect', 1, 14, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(20, 'Paste', 'paste', 'plugin', 'pasteword,pastetext', 'paste', 2, 1, 1, 1, 1, '', 0, '0000-00-00 00:00:00'),
(21, 'Search Replace', 'searchreplace', 'plugin', 'search,replace', 'searchreplace', 2, 2, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(22, 'Font ForeColour', 'forecolor', 'command', 'forecolor', 'forecolor', 2, 3, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(23, 'Font BackColour', 'backcolor', 'command', 'backcolor', 'backcolor', 2, 4, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(24, 'Unlink', 'unlink', 'command', 'unlink', 'unlink', 2, 5, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(25, 'Indent', 'indent', 'command', 'indent', 'indent', 2, 6, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(26, 'Outdent', 'outdent', 'command', 'outdent', 'outdent', 2, 7, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(27, 'Undo', 'undo', 'command', 'undo', 'undo', 2, 8, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(28, 'Redo', 'redo', 'command', 'redo', 'redo', 2, 9, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(29, 'HTML', 'html', 'command', 'code', 'code', 2, 10, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(30, 'Numbered List', 'numlist', 'command', 'numlist', 'numlist', 2, 11, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(31, 'Bullet List', 'bullist', 'command', 'bullist', 'bullist', 2, 12, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(32, 'Clipboard Actions', 'clipboard', 'command', 'cut,copy,paste', 'clipboard', 2, 13, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(33, 'Anchor', 'anchor', 'command', 'anchor', 'anchor', 2, 14, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(34, 'Image', 'image', 'command', 'image', 'image', 2, 15, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(35, 'Link', 'link', 'command', 'link', 'link', 2, 16, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(36, 'Code Cleanup', 'cleanup', 'command', 'cleanup', 'cleanup', 2, 17, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(37, 'Directionality', 'directionality', 'plugin', 'ltr,rtl', 'directionality', 3, 1, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(38, 'Emotions', 'emotions', 'plugin', 'emotions', 'emotions', 3, 2, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(39, 'Fullscreen', 'fullscreen', 'plugin', 'fullscreen', 'fullscreen', 3, 3, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(40, 'Preview', 'preview', 'plugin', 'preview', 'preview', 3, 4, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(41, 'Tables', 'table', 'plugin', 'tablecontrols', 'buttons', 3, 5, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(42, 'Print', 'print', 'plugin', 'print', 'print', 3, 6, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(43, 'Horizontal Rule', 'hr', 'command', 'hr', 'hr', 3, 7, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(44, 'Subscript', 'sub', 'command', 'sub', 'sub', 3, 8, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(45, 'Superscript', 'sup', 'command', 'sup', 'sup', 3, 9, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(46, 'Visual Aid', 'visualaid', 'command', 'visualaid', 'visualaid', 3, 10, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(47, 'Character Map', 'charmap', 'command', 'charmap', 'charmap', 3, 11, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(48, 'Remove Format', 'removeformat', 'command', 'removeformat', 'removeformat', 3, 12, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(49, 'Styles', 'style', 'plugin', 'styleprops', 'style', 4, 1, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(50, 'Non-Breaking', 'nonbreaking', 'plugin', 'nonbreaking', 'nonbreaking', 4, 2, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(51, 'Visual Characters', 'visualchars', 'plugin', 'visualchars', 'visualchars', 4, 3, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(52, 'XHTML Xtras', 'xhtmlxtras', 'plugin', 'cite,abbr,acronym,del,ins,attribs', 'xhtmlxtras', 4, 4, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(53, 'Image Manager', 'imgmanager', 'plugin', 'imgmanager', 'imgmanager', 4, 5, 1, 1, 1, '', 0, '0000-00-00 00:00:00'),
(54, 'Advanced Link', 'advlink', 'plugin', 'advlink', 'advlink', 4, 6, 1, 1, 1, '', 0, '0000-00-00 00:00:00'),
(55, 'Spell Checker', 'spellchecker', 'plugin', 'spellchecker', 'spellchecker', 4, 7, 1, 1, 1, '', 0, '0000-00-00 00:00:00'),
(56, 'Layers', 'layer', 'plugin', 'insertlayer,moveforward,movebackward,absolute', 'layer', 4, 8, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(57, 'Advanced Code Editor', 'advcode', 'plugin', 'advcode', 'advcode', 4, 9, 1, 0, 1, '', 0, '0000-00-00 00:00:00'),
(58, 'Article Breaks', 'article', 'plugin', 'readmore,pagebreak', 'article', 4, 10, 1, 0, 1, '', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_menu`
--

CREATE TABLE IF NOT EXISTS `jos_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menutype` varchar(75) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `alias` varchar(255) NOT NULL DEFAULT '',
  `link` text,
  `type` varchar(50) NOT NULL DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `parent` int(11) unsigned NOT NULL DEFAULT '0',
  `componentid` int(11) unsigned NOT NULL DEFAULT '0',
  `sublevel` int(11) DEFAULT '0',
  `ordering` int(11) DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pollid` int(11) NOT NULL DEFAULT '0',
  `browserNav` tinyint(4) DEFAULT '0',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `utaccess` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `lft` int(11) unsigned NOT NULL DEFAULT '0',
  `rgt` int(11) unsigned NOT NULL DEFAULT '0',
  `home` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `componentid` (`componentid`,`menutype`,`published`,`access`),
  KEY `menutype` (`menutype`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `jos_menu`
--

INSERT INTO `jos_menu` (`id`, `menutype`, `name`, `alias`, `link`, `type`, `published`, `parent`, `componentid`, `sublevel`, `ordering`, `checked_out`, `checked_out_time`, `pollid`, `browserNav`, `access`, `utaccess`, `params`, `lft`, `rgt`, `home`) VALUES
(1, 'mainmenu', 'Home', 'home', 'index.php?option=com_content&view=frontpage', 'component', 1, 0, 20, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, 'num_leading_articles=1\nnum_intro_articles=4\nnum_columns=2\nnum_links=4\norderby_pri=\norderby_sec=front\nshow_pagination=2\nshow_pagination_results=1\nshow_feed_link=1\nshow_noauth=\nshow_title=\nlink_titles=\nshow_intro=\nshow_section=\nlink_section=\nshow_category=\nlink_category=\nshow_author=\nshow_create_date=\nshow_modify_date=\nshow_item_navigation=\nshow_readmore=\nshow_vote=\nshow_icons=\nshow_pdf_icon=\nshow_print_icon=\nshow_email_icon=\nshow_hits=\nfeed_summary=\npage_title=\nshow_page_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n', 0, 0, 1),
(2, 'mainmenu', 'Artigos', 'artigos', 'index.php?option=com_ecomp&view=componente&id=25&limit=15', 'component', -2, 0, 41, 0, 0, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 'titulo=\nclasses=\ntemplate=\npage_title=\nshow_page_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n', 0, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_menu_types`
--

CREATE TABLE IF NOT EXISTS `jos_menu_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menutype` varchar(75) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `menutype` (`menutype`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `jos_menu_types`
--

INSERT INTO `jos_menu_types` (`id`, `menutype`, `title`, `description`) VALUES
(1, 'mainmenu', 'Main Menu', 'The main menu for the site');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_messages`
--

CREATE TABLE IF NOT EXISTS `jos_messages` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id_from` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id_to` int(10) unsigned NOT NULL DEFAULT '0',
  `folder_id` int(10) unsigned NOT NULL DEFAULT '0',
  `date_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `state` int(11) NOT NULL DEFAULT '0',
  `priority` int(1) unsigned NOT NULL DEFAULT '0',
  `subject` text NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`message_id`),
  KEY `useridto_state` (`user_id_to`,`state`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_messages`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_messages_cfg`
--

CREATE TABLE IF NOT EXISTS `jos_messages_cfg` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cfg_name` varchar(100) NOT NULL DEFAULT '',
  `cfg_value` varchar(255) NOT NULL DEFAULT '',
  UNIQUE KEY `idx_user_var_name` (`user_id`,`cfg_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `jos_messages_cfg`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_migration_backlinks`
--

CREATE TABLE IF NOT EXISTS `jos_migration_backlinks` (
  `itemid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `url` text NOT NULL,
  `sefurl` text NOT NULL,
  `newurl` text NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `jos_migration_backlinks`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_modules`
--

CREATE TABLE IF NOT EXISTS `jos_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `position` varchar(50) DEFAULT NULL,
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `module` varchar(50) DEFAULT NULL,
  `numnews` int(11) NOT NULL DEFAULT '0',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `showtitle` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  `iscore` tinyint(4) NOT NULL DEFAULT '0',
  `client_id` tinyint(4) NOT NULL DEFAULT '0',
  `control` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Extraindo dados da tabela `jos_modules`
--

INSERT INTO `jos_modules` (`id`, `title`, `content`, `ordering`, `position`, `checked_out`, `checked_out_time`, `published`, `module`, `numnews`, `access`, `showtitle`, `params`, `iscore`, `client_id`, `control`) VALUES
(1, 'Main Menu', '', 1, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 1, 'menutype=mainmenu\nmoduleclass_sfx=_menu\n', 1, 0, ''),
(2, 'Login', '', 1, 'login', 0, '0000-00-00 00:00:00', 1, 'mod_login', 0, 0, 1, '', 1, 1, ''),
(3, 'Popular', '', 3, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_popular', 0, 2, 1, '', 0, 1, ''),
(4, 'Recent added Articles', '', 4, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_latest', 0, 2, 1, 'ordering=c_dsc\nuser_id=0\ncache=0\n\n', 0, 1, ''),
(5, 'Menu Stats', '', 5, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_stats', 0, 2, 1, '', 0, 1, ''),
(6, 'Unread Messages', '', 1, 'header', 0, '0000-00-00 00:00:00', 1, 'mod_unread', 0, 2, 1, '', 1, 1, ''),
(7, 'Online Users', '', 2, 'header', 0, '0000-00-00 00:00:00', 1, 'mod_online', 0, 2, 1, '', 1, 1, ''),
(8, 'Toolbar', '', 1, 'toolbar', 0, '0000-00-00 00:00:00', 1, 'mod_toolbar', 0, 2, 1, '', 1, 1, ''),
(9, 'Quick Icons', '', 1, 'icon', 0, '0000-00-00 00:00:00', 1, 'mod_quickicon', 0, 2, 1, '', 1, 1, ''),
(10, 'Logged in Users', '', 2, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_logged', 0, 2, 1, '', 0, 1, ''),
(11, 'Footer', '', 0, 'footer', 0, '0000-00-00 00:00:00', 1, 'mod_footer', 0, 0, 1, '', 1, 1, ''),
(12, 'Admin Menu', '', 1, 'menu', 0, '0000-00-00 00:00:00', 1, 'mod_menu', 0, 2, 1, '', 0, 1, ''),
(13, 'Admin SubMenu', '', 1, 'submenu', 0, '0000-00-00 00:00:00', 1, 'mod_submenu', 0, 2, 1, '', 0, 1, ''),
(14, 'User Status', '', 1, 'status', 0, '0000-00-00 00:00:00', 1, 'mod_status', 0, 2, 1, '', 0, 1, ''),
(15, 'Title', '', 1, 'title', 0, '0000-00-00 00:00:00', 1, 'mod_title', 0, 2, 1, '', 0, 1, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_modules_menu`
--

CREATE TABLE IF NOT EXISTS `jos_modules_menu` (
  `moduleid` int(11) NOT NULL DEFAULT '0',
  `menuid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`moduleid`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `jos_modules_menu`
--

INSERT INTO `jos_modules_menu` (`moduleid`, `menuid`) VALUES
(1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_newsfeeds`
--

CREATE TABLE IF NOT EXISTS `jos_newsfeeds` (
  `catid` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `alias` varchar(255) NOT NULL DEFAULT '',
  `link` text NOT NULL,
  `filename` varchar(200) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `numarticles` int(11) unsigned NOT NULL DEFAULT '1',
  `cache_time` int(11) unsigned NOT NULL DEFAULT '3600',
  `checked_out` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `rtl` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `published` (`published`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_newsfeeds`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_plugins`
--

CREATE TABLE IF NOT EXISTS `jos_plugins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `element` varchar(100) NOT NULL DEFAULT '',
  `folder` varchar(100) NOT NULL DEFAULT '',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `published` tinyint(3) NOT NULL DEFAULT '0',
  `iscore` tinyint(3) NOT NULL DEFAULT '0',
  `client_id` tinyint(3) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_folder` (`published`,`client_id`,`access`,`folder`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

--
-- Extraindo dados da tabela `jos_plugins`
--

INSERT INTO `jos_plugins` (`id`, `name`, `element`, `folder`, `access`, `ordering`, `published`, `iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`) VALUES
(1, 'Authentication - Joomla', 'joomla', 'authentication', 0, 1, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(2, 'Authentication - LDAP', 'ldap', 'authentication', 0, 2, 0, 1, 0, 0, '0000-00-00 00:00:00', 'host=\nport=389\nuse_ldapV3=0\nnegotiate_tls=0\nno_referrals=0\nauth_method=bind\nbase_dn=\nsearch_string=\nusers_dn=\nusername=\npassword=\nldap_fullname=fullName\nldap_email=mail\nldap_uid=uid\n\n'),
(3, 'Authentication - GMail', 'gmail', 'authentication', 0, 4, 0, 0, 0, 0, '0000-00-00 00:00:00', ''),
(4, 'Authentication - OpenID', 'openid', 'authentication', 0, 3, 0, 0, 0, 0, '0000-00-00 00:00:00', ''),
(5, 'User - Joomla!', 'joomla', 'user', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', 'autoregister=1\n\n'),
(6, 'Search - Content', 'content', 'search', 0, 1, 1, 1, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\nsearch_content=1\nsearch_uncategorised=1\nsearch_archived=1\n\n'),
(7, 'Search - Contacts', 'contacts', 'search', 0, 3, 1, 1, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(8, 'Search - Categories', 'categories', 'search', 0, 4, 1, 0, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(9, 'Search - Sections', 'sections', 'search', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(10, 'Search - Newsfeeds', 'newsfeeds', 'search', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(11, 'Search - Weblinks', 'weblinks', 'search', 0, 2, 1, 1, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(12, 'Content - Pagebreak', 'pagebreak', 'content', 0, 10000, 1, 1, 0, 0, '0000-00-00 00:00:00', 'enabled=1\ntitle=1\nmultipage_toc=1\nshowall=1\n\n'),
(13, 'Content - Rating', 'vote', 'content', 0, 4, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(14, 'Content - Email Cloaking', 'emailcloak', 'content', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', 'mode=1\n\n'),
(15, 'Content - Code Hightlighter (GeSHi)', 'geshi', 'content', 0, 5, 0, 0, 0, 0, '0000-00-00 00:00:00', ''),
(16, 'Content - Load Module', 'loadmodule', 'content', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', 'enabled=1\nstyle=0\n\n'),
(17, 'Content - Page Navigation', 'pagenavigation', 'content', 0, 2, 1, 1, 0, 0, '0000-00-00 00:00:00', 'position=1\n\n'),
(18, 'Editor - No Editor', 'none', 'editors', 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(19, 'Editor - TinyMCE', 'tinymce', 'editors', 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', 'theme=advanced\ncleanup=1\ncleanup_startup=0\nautosave=0\ncompressed=0\nrelative_urls=1\ntext_direction=ltr\nlang_mode=0\nlang_code=en\ninvalid_elements=applet\ncontent_css=1\ncontent_css_custom=\nnewlines=0\ntoolbar=top\nhr=1\nsmilies=1\ntable=1\nstyle=1\nlayer=1\nxhtmlxtras=0\ntemplate=0\ndirectionality=1\nfullscreen=1\nhtml_height=550\nhtml_width=750\npreview=1\ninsertdate=1\nformat_date=%Y-%m-%d\ninserttime=1\nformat_time=%H:%M:%S\n\n'),
(20, 'Editor - XStandard Lite 2.0', 'xstandard', 'editors', 0, 0, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(21, 'Editor Button - Image', 'image', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(22, 'Editor Button - Pagebreak', 'pagebreak', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(23, 'Editor Button - Readmore', 'readmore', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(24, 'XML-RPC - Joomla', 'joomla', 'xmlrpc', 0, 7, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(25, 'XML-RPC - Blogger API', 'blogger', 'xmlrpc', 0, 7, 0, 1, 0, 0, '0000-00-00 00:00:00', 'catid=1\nsectionid=0\n\n'),
(27, 'System - SEF', 'sef', 'system', 0, 1, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(28, 'System - Debug', 'debug', 'system', 0, 2, 1, 0, 0, 0, '0000-00-00 00:00:00', 'queries=1\nmemory=1\nlangauge=1\n\n'),
(29, 'System - Legacy', 'legacy', 'system', 0, 3, 0, 1, 0, 0, '0000-00-00 00:00:00', 'route=0\n\n'),
(30, 'System - Cache', 'cache', 'system', 0, 4, 0, 1, 0, 0, '0000-00-00 00:00:00', 'browsercache=0\ncachetime=15\n\n'),
(31, 'System - Log', 'log', 'system', 0, 5, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(32, 'System - Remember Me', 'remember', 'system', 0, 6, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(33, 'System - Backlink', 'backlink', 'system', 0, 7, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(34, 'Editor - JCE 154', 'jce', 'editors', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(37, 'System - eFormMail', 'eformmail', 'system', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(36, 'System - eLoad', 'eload', 'system', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', 'addJquery=1\nversionJquery=1.3.2\nremoveMootools=1\nremoveMootoolsUncompressed=1\nremoveCaption=1\ngenerator=1\ntitulo=1\ntituloSite={sitename} - {title}\neImageResizeAll=2\neImageResizeClass=eImageResize\neImageNoResizeClass=eImageNoResize\nlightBox-active=1\nlightBox-overlayOpacity=0.8\nlightBox-txtImage=Imagem\nlightBox-txtOf=de\nfirebug-adicionar=0\nanalytics-adicionar=1\nanalytics-UA=\n\n');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_polls`
--

CREATE TABLE IF NOT EXISTS `jos_polls` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `voters` int(9) NOT NULL DEFAULT '0',
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `access` int(11) NOT NULL DEFAULT '0',
  `lag` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_polls`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_poll_data`
--

CREATE TABLE IF NOT EXISTS `jos_poll_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pollid` int(11) NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `hits` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pollid` (`pollid`,`text`(1))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_poll_data`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_poll_date`
--

CREATE TABLE IF NOT EXISTS `jos_poll_date` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `vote_id` int(11) NOT NULL DEFAULT '0',
  `poll_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `poll_id` (`poll_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_poll_date`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_poll_menu`
--

CREATE TABLE IF NOT EXISTS `jos_poll_menu` (
  `pollid` int(11) NOT NULL DEFAULT '0',
  `menuid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pollid`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `jos_poll_menu`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_sections`
--

CREATE TABLE IF NOT EXISTS `jos_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `image` text NOT NULL,
  `scope` varchar(50) NOT NULL DEFAULT '',
  `image_position` varchar(30) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_scope` (`scope`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_sections`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_session`
--

CREATE TABLE IF NOT EXISTS `jos_session` (
  `username` varchar(150) DEFAULT '',
  `time` varchar(14) DEFAULT '',
  `session_id` varchar(200) NOT NULL DEFAULT '0',
  `guest` tinyint(4) DEFAULT '1',
  `userid` int(11) DEFAULT '0',
  `usertype` varchar(50) DEFAULT '',
  `gid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `client_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `data` longtext,
  PRIMARY KEY (`session_id`(64)),
  KEY `whosonline` (`guest`,`usertype`),
  KEY `userid` (`userid`),
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `jos_session`
--

INSERT INTO `jos_session` (`username`, `time`, `session_id`, `guest`, `userid`, `usertype`, `gid`, `client_id`, `data`) VALUES
('', '1259352692', '8fbce1b9676a9c30db064f6114e79967', 1, 0, '', 0, 0, '__default|a:7:{s:15:"session.counter";i:69;s:19:"session.timer.start";i:1259327952;s:18:"session.timer.last";i:1259352400;s:17:"session.timer.now";i:1259352692;s:22:"session.client.browser";s:109:"Mozilla/5.0 (Windows; U; Windows NT 6.1; pt-BR; rv:1.9.1.5) Gecko/20091102 Firefox/3.5.5 (.NET CLR 3.5.30729)";s:8:"registry";O:9:"JRegistry":3:{s:17:"_defaultNameSpace";s:7:"session";s:9:"_registry";a:1:{s:7:"session";a:1:{s:4:"data";O:8:"stdClass":0:{}}}s:7:"_errors";a:0:{}}s:4:"user";O:5:"JUser":19:{s:2:"id";i:0;s:4:"name";N;s:8:"username";N;s:5:"email";N;s:8:"password";N;s:14:"password_clear";s:0:"";s:8:"usertype";N;s:5:"block";N;s:9:"sendEmail";i:0;s:3:"gid";i:0;s:12:"registerDate";N;s:13:"lastvisitDate";N;s:10:"activation";N;s:6:"params";N;s:3:"aid";i:0;s:5:"guest";i:1;s:7:"_params";O:10:"JParameter":7:{s:4:"_raw";s:0:"";s:4:"_xml";N;s:9:"_elements";a:0:{}s:12:"_elementPath";a:1:{i:0;s:69:"D:\\SITES\\www\\tonhoimoveis\\pub\\libraries\\joomla\\html\\parameter\\element";}s:17:"_defaultNameSpace";s:8:"_default";s:9:"_registry";a:1:{s:8:"_default";a:1:{s:4:"data";O:8:"stdClass":0:{}}}s:7:"_errors";a:0:{}}s:9:"_errorMsg";N;s:7:"_errors";a:0:{}}}'),
('admin', '1259352720', 'a903d4d6767e85cdd2992bd7aa0ff32f', 0, 62, 'Super Administrator', 25, 1, '__default|a:8:{s:15:"session.counter";i:47;s:19:"session.timer.start";i:1259327964;s:18:"session.timer.last";i:1259352720;s:17:"session.timer.now";i:1259352720;s:22:"session.client.browser";s:109:"Mozilla/5.0 (Windows; U; Windows NT 6.1; pt-BR; rv:1.9.1.5) Gecko/20091102 Firefox/3.5.5 (.NET CLR 3.5.30729)";s:8:"registry";O:9:"JRegistry":3:{s:17:"_defaultNameSpace";s:7:"session";s:9:"_registry";a:4:{s:7:"session";a:1:{s:4:"data";O:8:"stdClass":0:{}}s:11:"application";a:1:{s:4:"data";O:8:"stdClass":1:{s:4:"lang";s:0:"";}}s:6:"global";a:1:{s:4:"data";O:8:"stdClass":1:{s:4:"list";O:8:"stdClass":1:{s:5:"limit";i:0;}}}s:13:"com_installer";a:1:{s:4:"data";O:8:"stdClass":1:{s:10:"limitstart";O:8:"stdClass":2:{s:9:"component";i:0;s:6:"plugin";i:0;}}}}s:7:"_errors";a:0:{}}s:4:"user";O:5:"JUser":19:{s:2:"id";s:2:"62";s:4:"name";s:13:"Administrator";s:8:"username";s:5:"admin";s:5:"email";s:16:"seu@email.com.br";s:8:"password";s:65:"c4b7b93e384c769d37feec66e78f1b0b:e83WJUGtz4HlTfavAmuT5CHvSsZ53qpZ";s:14:"password_clear";s:0:"";s:8:"usertype";s:19:"Super Administrator";s:5:"block";s:1:"0";s:9:"sendEmail";s:1:"1";s:3:"gid";s:2:"25";s:12:"registerDate";s:19:"2009-09-11 10:00:04";s:13:"lastvisitDate";s:19:"2009-11-18 14:33:15";s:10:"activation";s:0:"";s:6:"params";s:70:"admin_language=pt-BR\nlanguage=pt-BR\neditor=jce\nhelpsite=\ntimezone=-3\n\n";s:3:"aid";i:2;s:5:"guest";i:0;s:7:"_params";O:10:"JParameter":7:{s:4:"_raw";s:0:"";s:4:"_xml";N;s:9:"_elements";a:0:{}s:12:"_elementPath";a:1:{i:0;s:69:"D:\\SITES\\www\\tonhoimoveis\\pub\\libraries\\joomla\\html\\parameter\\element";}s:17:"_defaultNameSpace";s:8:"_default";s:9:"_registry";a:1:{s:8:"_default";a:1:{s:4:"data";O:8:"stdClass":5:{s:14:"admin_language";s:5:"pt-BR";s:8:"language";s:5:"pt-BR";s:6:"editor";s:3:"jce";s:8:"helpsite";s:0:"";s:8:"timezone";s:2:"-3";}}}s:7:"_errors";a:0:{}}s:9:"_errorMsg";N;s:7:"_errors";a:0:{}}s:13:"session.token";s:32:"5cc5f2cb9e0412545e8c2aef4db6eebd";}');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_stats_agents`
--

CREATE TABLE IF NOT EXISTS `jos_stats_agents` (
  `agent` varchar(255) NOT NULL DEFAULT '',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `jos_stats_agents`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_templates_menu`
--

CREATE TABLE IF NOT EXISTS `jos_templates_menu` (
  `template` varchar(255) NOT NULL DEFAULT '',
  `menuid` int(11) NOT NULL DEFAULT '0',
  `client_id` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`menuid`,`client_id`,`template`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `jos_templates_menu`
--

INSERT INTO `jos_templates_menu` (`template`, `menuid`, `client_id`) VALUES
('rhuk_milkyway', 0, 0),
('khepri', 0, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_users`
--

CREATE TABLE IF NOT EXISTS `jos_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(150) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `usertype` varchar(25) NOT NULL DEFAULT '',
  `block` tinyint(4) NOT NULL DEFAULT '0',
  `sendEmail` tinyint(4) DEFAULT '0',
  `gid` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `registerDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL DEFAULT '',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usertype` (`usertype`),
  KEY `idx_name` (`name`),
  KEY `gid_block` (`gid`,`block`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=64 ;

--
-- Extraindo dados da tabela `jos_users`
--

INSERT INTO `jos_users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `gid`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(62, 'Administrator', 'admin', 'seu@email.com.br', 'c4b7b93e384c769d37feec66e78f1b0b:e83WJUGtz4HlTfavAmuT5CHvSsZ53qpZ', 'Super Administrator', 0, 1, 25, '2009-09-11 10:00:04', '2009-11-27 13:19:44', '', 'admin_language=pt-BR\nlanguage=pt-BR\neditor=jce\nhelpsite=\ntimezone=-3\n\n');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jos_weblinks`
--

CREATE TABLE IF NOT EXISTS `jos_weblinks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT '0',
  `sid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(250) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(250) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `approved` tinyint(1) NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `catid` (`catid`,`published`,`archived`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `jos_weblinks`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `versao_db`
--

CREATE TABLE IF NOT EXISTS `versao_db` (
  `requerido_0001` bit(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `versao_db`
--




-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
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






-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- REQUERIDO 0002

ALTER TABLE `versao_db` CHANGE `requerido_0002` `requerido_0003` BIT(1) NULL DEFAULT NULL;

UPDATE `jos_plugins` SET `params` = 'jqueryAdd=1
jqueryServer=localhost
jqueryVersion=1.4
removeMootools=1
removeMootoolsUncompressed=1
removeCaption=1
generator=1
titulo=1
tituloSite={sitename} - {title}
eImageResizeAll=2
eImageResizeClass=eImageResize
eImageNoResizeClass=eImageNoResize
lightBox-active=1
lightBox-overlayOpacity=0.8
lightBox-txtImage=Imagem
lightBox-txtOf=de
firebug-adicionar=0
analytics-adicionar=1
analytics-UA=' WHERE `jos_plugins`.`id` = 36 LIMIT 1;







-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- REQUERIDO 0003

ALTER TABLE `versao_db` CHANGE `requerido_0003` `requerido_0004` BIT(1) NULL DEFAULT NULL;

ALTER TABLE `jos_ecomp_routers_rules`  ADD `idcomponente` INT(11) NOT NULL AFTER `itemid`;






-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- REQUERIDO 0004

ALTER TABLE `versao_db` CHANGE `requerido_0004` `requerido_0005` BIT(1) NULL DEFAULT NULL;

UPDATE `jos_plugins` SET `params` = 'jqueryAdd=1
jqueryServer=localhost
jqueryVersion=1.4.1
removeMootools=1
removeMootoolsUncompressed=1
removeCaption=1
generator=1
titulo=1
tituloSite={sitename} - {title}
eImageResizeAll=2
eImageResizeClass=eImageResize
eImageNoResizeClass=eImageNoResize
lightBox-active=1
lightBox-overlayOpacity=0.8
lightBox-txtImage=Imagem
lightBox-txtOf=de
firebug-adicionar=0
analytics-adicionar=1
analytics-UA=' WHERE `jos_plugins`.`id` = 36 LIMIT 1;




-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- REQUERIDO 0005

ALTER TABLE `versao_db` CHANGE `requerido_0005` `requerido_0006` BIT(1) NULL DEFAULT NULL;

DELETE FROM `jos_menu` WHERE `id` = 2 LIMIT 1;




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





-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- REQUERIDO 0007

ALTER TABLE `versao_db` CHANGE `requerido_0007` `requerido_0008` BIT(1) NULL DEFAULT NULL;

UPDATE `jos_plugins` SET `params` = 'jqueryAdd=1
jqueryServer=localhost
jqueryVersion=1.4.2
removeMootools=1
removeMootoolsUncompressed=1
removeCaption=1
generator=1
AtualizeSeuNavegador=1
titulo=1
tituloSite={sitename} - {title}
eImageResizeAll=2
eImageResizeClass=eImageResize
eImageNoResizeClass=eImageNoResize
lightBox-active=1
lightBox-overlayOpacity=0.8
lightBox-txtImage=Imagem
lightBox-txtOf=de
firebug-adicionar=0
analytics-adicionar=1
analytics-UA=' WHERE `jos_plugins`.`id` = 36 LIMIT 1;




-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- ----------------------------------------------------------------------------------------------
-- REQUERIDO 0008

ALTER TABLE `versao_db` CHANGE `requerido_0008` `requerido_0009` BIT(1) NULL DEFAULT NULL;

ALTER TABLE `jos_users` ADD `id_grupo` INT( 11 ) NOT NULL AFTER `id`;
UPDATE `jos_users` SET `id_grupo` =  '1' WHERE `jos_users`.`id` =62 LIMIT 1 ;





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



