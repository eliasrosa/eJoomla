<? $menu_usuarios->show(); ?>
<h1>Lista de usuários</h1>
<p>Edite e remova usuários do sitema.</p>

<?
$a = new JCRUD("jos_users");
$t = $a->busca_tudo("name");

$user =& JFactory::getUser();

?>

<form rel="<?= $this->processID; ?>" method="post" action="<?= $this->formURL('usuarios.remover'); ?>">
	<table class="ui-corner-top">
		<tr class="ui-widget-header">
			<td></td>
			<td>Nome</td>
			<td>Usuário</td>
			<td>E-mail</td>
		</tr>

	<? foreach($t as $u): ?>
		<tr class="ui-widget-content">
			<td><? if($user->id != $u->id): ?><input type="checkbox" name="ids[]" value="<?= $u->id; ?>" /><? endif; ?></td>
			<td><strong><?= $u->name ?></strong>
				<div class="actions">
					<span class="editar"><a class="link" rel="{'pagina': 'usuarios.editar', 'query': 'id=<?= $u->id; ?>'}" href="javascript:void(0);">Editar</a></span>
					<? if($user->id != $u->id): ?><span class="excluir"><a href="javascript:void(0);">Excluír</a></span><? endif; ?>
				</div>
			</td>
			<td><?= $u->username ?></td>
			<td><?= $u->email ?></td>
		</tr>
	<? endforeach ?>		
	</table>
	<p class="excluir"><a href="javascript:void(0);">Excluír selecionados</a></p>
</form>

