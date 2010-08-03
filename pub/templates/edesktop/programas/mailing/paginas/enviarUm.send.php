<?
$idemail = JRequest::getInt('email', 0); 
$contato = JRequest::getVar('contato');

jimport('edesktop.programas.mailing');

$m = new edMailing();
$e = $m->enviar_email($contato, $idemail);

jexit(json_encode($e));
?>