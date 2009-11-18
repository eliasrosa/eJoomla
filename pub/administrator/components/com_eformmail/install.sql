
CREATE TABLE IF NOT EXISTS `#__eformmail_formularios` (
  `id` int(11) NOT NULL auto_increment,
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
  `trashed` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
