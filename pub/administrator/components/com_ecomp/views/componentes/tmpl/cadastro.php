<? defined('_JEXEC') or die('Acesso restrito'); ?>
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
						<input class="text_area" type="text" name="nome" id="nome"
						size="100" maxlength="100" value="<?php echo @$this->row->nome ?>" />
					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="key">
						<label for="greeting">Alias:</label>
					</td>
					<td>
						<?php echo @$this->row->alias ?>
						<input type="hidden" name="alias" value="<?php echo @$this->row->alias ?>" />
					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="key">
						<label for="greeting">Publicado:</label>
					</td>
					<td>
						<?= $this->util('cadastro.published'); ?>
					</td>
				</tr>
			</table>
		</fieldset>
	</div>

	<div class="clr"></div>
	<?= $this->util('cadastro.hiddens')?>

</form>
