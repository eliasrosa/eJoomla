<?
$menu_principal->show();
jimport('edesktop.programas.mailing');

$m = new edMailing();
$emails = $m->busca_todos_emails_ativos();

?>
<h1>Enviar e-mail</h1>
<p>Envie e-mails para um contato</p>

<form rel="<?= $this->processID ?>" method="post" action="">
	<div class="line">
		<span>E-mail</span>
		<select name="email" class="w100">
			<? foreach ($emails as $e): ?>
				<option value="<?= $e->id ?>"><?= $e->nome ?> (<?= $e->Remetente->nome ?>)</option>
			<? endforeach; ?>
		</select>
		<br class="clearfix"/>
	</div>

	<div class="line">
		<span>E-mail do destinatário</span>
		<input type="text" name="contato" class="w100" value="" rel="email_" title="E-mail do destinatáro" />
		<br class="clearfix"/>
	</div>
				
	<p class="acoes tac">
		<input class="submit" type="submit" value="Enviar e-mail" />
	</p>
</form>
