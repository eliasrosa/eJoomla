<?
defined('_JEXEC') or die('Acesso restrito');

require_once(ECOMP_PATH_CLASS.DS.'ecomp.listas.class.php');

$idcomponente = JRequest::getVar('idcomponente', 0);

?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
	<div class="col100">
		<fieldset class="adminform">

			<legend><?php echo JText::_( 'Detalhes' ); ?></legend>
			<table class="admintable">

				<tr>
					<td width="100" align="right" class="key">
						<label for="greeting">Nome:</label>
					</td>
					<td>
						<input class="text_area" type="text" name="nome"
						size="100" maxlength="255" value="<?= htmlspecialchars(@$this->row->nome); ?>" />
					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="key">
						<label for="greeting">Alias:</label>
					</td>
					<td>
						<input class="text_area" type="text" name="alias"
						size="100" maxlength="255" value="<?= htmlspecialchars(@$this->row->alias); ?>" />
					</td>
				</tr>

				<tr>
					<td width="100" align="right" class="key">
						<label for="greeting">Tag pai:</label>
					</td>
					<td>
						<?
							$lista = new ecompListas();
							$lista->getListaTagsPai(@$this->row->id, @$this->row->idpai);
						?>
					</td>
				</tr>




				<tr>
					<td width="100" align="right" class="key">
						<label for="greeting"><?= JText::_( 'Ordem' ); ?>:</label>
					</td>
					<td>
						<input class="text_area" type="text" name="ordering"
						size="5" maxlength="11" value="<?= @$this->row->ordering?>" />
					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="key">
						<label for="greeting"><?= JText::_( 'Publicado' ); ?>:</label>
					</td>
					<td>
						<?= $this->util('cadastro.published'); ?>
					</td>
				</tr>

			</table>
		</fieldset>
	</div>

	<div class="clr"></div>

	<input type="hidden" name="idcomponente" value="<?= $idcomponente ?>" />

	<?= $this->util('cadastro.hiddens')?>

</form>
