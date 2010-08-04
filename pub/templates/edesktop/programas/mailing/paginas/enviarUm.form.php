<?
$menu_principal->show();
jimport('edesktop.programas.mailing');

$m = new edMailing();
$emails = $m->busca_todos_emails_ativos();
$contatos = $m->busca_todos_contatos_ativos();

$c = array();
foreach($contatos as $contato)
	$c[] = $contato->email;
	
$contatos = json_encode($c);
?>
<script>
$(function(){
	var $form = $('form', $('#d<?= $this->processID; ?>'));

	$("input[name='contato']", $form).autocomplete({
		source: <?= $contatos; ?>,
		minLength: 2
	});
	$('ul.ui-autocomplete').css({left: 364, top: ''});
});
</script>

<h1>Enviar e-mail para um contato</h1>
<p>Envie um e-mail para um único contato de suas listas</p>

<form rel="<?= $this->processID ?>" method="post" action="">
	<div class="line">
		<span>E-mail</span>
		<select name="email" class="w100">
			<? foreach ($emails as $e): ?>
				<option value="<?= $e->id ?>"><?= $e->assunto ?> (<?= $e->Remetente->nome ?>)</option>
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
