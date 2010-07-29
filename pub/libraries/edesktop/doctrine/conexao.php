<?php
// Insira aqui o caminho do doctrine
jimport('edesktop.doctrine.Doctrine');

// Essas linhas são responsáveis pelo carregamento dos dois frameworks
spl_autoload_register('MyLoader::autoload');
class MyLoader
{	
	public static function autoload($className)
	{
		Doctrine::autoload($className);
		Doctrine::modelsAutoload($className);
		JLoader::load($className);
		return true;
	}
}

try
{
	// Carrega as config do joomla
	$config = JFactory::getConfig();
	
	// Inicia
	$manager = Doctrine_Manager::getInstance();
	
	// Insira aqui os dados de sua conexão
	$conn = Doctrine_Manager::connection(
		$config->getValue('config.dbtype').'://'.
		$config->getValue('config.user').':'.
		$config->getValue('config.password').'@'.
		$config->getValue('config.host').'/'.
		$config->getValue('config.db'), 'default');


	$manager->setAttribute(Doctrine_Core::ATTR_QUOTE_IDENTIFIER, true);
	$manager->setAttribute(Doctrine_Core::ATTR_MODEL_LOADING, Doctrine_Core::MODEL_LOADING_CONSERVATIVE);
	$manager->setAttribute(Doctrine_Core::ATTR_EXPORT, Doctrine_Core::EXPORT_ALL);
	$manager->setAttribute(Doctrine_Core::ATTR_AUTOLOAD_TABLE_CLASSES, true);
	$manager->setAttribute(Doctrine_Core::ATTR_VALIDATE, Doctrine_Core::VALIDATE_ALL);
	
	$conn->setCollate('utf8_general_ci');
	$conn->setCharset('utf8');

	$profiler = new Doctrine_Connection_Profiler();
	$manager->setListener($profiler);
}
catch (Doctrine_Manager_Exception $e)
{
	print $e->getMessage();
}
