<?
jimport('edesktop.programas.base');
Doctrine_Core::loadModels(dirname(__FILE__) .DS. 'mailing' .DS);

class edMailing extends eDesktoBase
{

	public function enviar_email($contato, $idemail)
	{
		$idemail = util::int($idemail);
		
		
		
		return ;
	}



}
?>