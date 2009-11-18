<?php
defined('_JEXEC') or die( "Acesso Restrito" );


function subText($post, $txt)
{
	foreach($post as $k=>$p)
	{
		$txt = str_replace("[$k]", $p, $txt);
	}

	return $txt;
}


// Envia o e-mail
if(JRequest::get('post'))
{
	$post    = JRequest::get('post');
	$id      = $post['eformmail_id'];
	$upload  = $post['eformmail_upload'];
	$token   = JRequest::getVar('token');

	$db      =& JFactory::getDBO();
	$query   = "SELECT * FROM #__eformmail_formularios WHERE id = '{$id}' AND published = '1' AND trashed != '1'";
	$dados   = $db->setQuery($query);
	$dados   = $db->loadObject();

	$to      = subText($post, $dados->to);
	$subject = subText($post, $dados->subject);
	$message = subText($post, $dados->message);

	$from    = subText($post, $dados->from);
	$replyto = subText($post, $dados->replyto);
	$cc      = subText($post, $dados->cc);
	$co      = subText($post, $dados->co);

	$charset = $dados->charset;
	$type    = $dados->type;

	$headers = 'Content-type: '.$type.'; charset='.$charset.';' . "\r\n".
			   'From: ' . $from . "\r\n" .
			   'Reply-To: '. $replyto . "\r\n" .
			   'X-Mailer: eFormMail - PHP/' . phpversion();


	if(mail($to, $subject, $message, $headers)) die("Sua mensagem foi enviada com sucesso.");
	else die("Erro ao tentar enviar o e-mail!");

}

?>
