<?php
defined('_JEXEC') or die('Restricted access');

header ('Content-type: text/html; charset=utf-8');

// importa a class categorias
jimport('edesktop.programas.mailing');

$id = JRequest::getInt('id');
$id = util::int($id);

$m = new edMailing();
$c = JRequest::getVar('e');
$sid = JRequest::getVar('sid');

$sid2 = $m->getSID($id, $c);
$email = $m->busca_email_ativo_id($id);

if($email && $sid == $sid2)
{
	$html = $m->createHtml($email, $c);
	jexit($html);
}
else
	jexit('E-mail não encontrado!');
?>
