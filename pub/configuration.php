<?php
class JConfig {

	/* Altere somente os valores abaixo */
	
	var $sitename          = 'NOME DO SITE';
	var $mailfrom          = 'SEU E-MAIL';
	var $host              = 'SERVIDOR MYSQL';
	var $user              = 'USUÁRIO MYSQL';
	var $db                = 'BANCO DE DADOS MYSQL';
	var $password          = 'SENHA DO BANCO DE DADOS';
	
	/* Altere somente os valores acima */
	
	var $offline           = '0';
	var $editor            = 'jce';
	var $list_limit        = '20';
	var $helpurl           = 'http://help.joomla.org';
	var $debug             = '0';
	var $debug_lang        = '0';
	var $sef               = '1';
	var $sef_rewrite       = '1';
	var $sef_suffix        = '1';
	var $feed_limit        = '10';
	var $feed_email        = 'author';
	var $secret            = 'a7f2ohMp7rHx0Mnx';
	var $gzip              = '0';
	var $error_reporting   = '-1';
	var $xmlrpc_server     = '0';
	var $log_path          = 'logs';
	var $tmp_path          = 'tmp';
	var $live_site         = '';
	var $force_ssl         = '0';
	var $offset            = '0';
	var $caching           = '0';
	var $cachetime         = '15';
	var $cache_handler     = 'file';
	var $memcache_settings = array();
	var $ftp_enable        = '0';
	var $ftp_host          = '127.0.0.1';
	var $ftp_port          = '21';
	var $ftp_user          = '';
	var $ftp_pass          = '';
	var $ftp_root          = '';	
	var $dbprefix          = 'jos_';
	var $dbtype            = 'mysql';	
	var $mailer            = 'mail';
	var $fromname          = 'Joomla';
	var $sendmail          = '/usr/sbin/sendmail';
	var $smtpauth          = '0';
	var $smtpsecure        = 'none';
	var $smtpport          = '25';
	var $smtpuser          = '';
	var $smtppass          = '';
	var $smtphost          = 'localhost';
	var $MetaAuthor        = '1';
	var $MetaTitle         = '1';
	var $lifetime          = '200';
	var $session_handler   = 'database';
	var $MetaDesc          = '';
	var $MetaKeys          = '';
	var $offline_message   = 'Este site está em manutenção. Por favor, retorne mais tarde.';
}
?>
