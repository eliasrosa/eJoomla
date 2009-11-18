<?
defined('_JEXEC') or die('Acesso restrito');

$idcomponente = JRequest::getVar('idcomponente', 0);
$idcadastro   = JRequest::getVar('idcadastro', 0);

$editor =& JFactory::getEditor();
?>
<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	<div class="col100">
		<fieldset class="adminform">

			<? if($this->row->id){ ?>
			<img style="float: right; margin-right: 8px; border: 1px solid #DDD; " src="../images/com_ecomp/<?= $idcomponente.'/'.$idcadastro.'/'.$this->row->id.'_m.jpg' ?>" />
			<? } ?>

			<legend>Detalhes</legend>
			<table class="admintable">
				<tr>
					<td width="100" align="right" class="key">Caminho da imagem:</td>
					<td><?php echo @$this->row->id ? "images/com_ecomp/{$idcomponente}/{$idcadastro}/{$this->row->file}" : '' ?></td>
				</tr>
				<tr>
					<td align="right" class="key">Enviar imagem:</td>
					<td><input name="Filedata" type="file" /> Tamanho máximo: <?= ini_get('upload_max_filesize') ?></td>
				</tr>
				<tr>
					<td align="right" class="key">Legenda:</td>
					<td><input class="text_area" type="text" name="legenda" id="nome" size="100" maxlength="255" value="<?php echo htmlspecialchars(stripslashes(@$this->row->legenda)) ?>" /></td>
				</tr>
				<tr>
					<td align="right" valign="top" class="key">Descrição:</td>
					<td><? echo $editor->display('descricao', stripslashes(@$this->row->descricao), 417, 350, '60', '20', false); ?></td>
				</tr>
				<tr>
					<td align="right" valign="top" class="key">Resumo:</td>
					<td><? echo $editor->display('resumo', stripslashes(@$this->row->resumo), 417, 350, '60', '20', false);	?></td>
				</tr>
				<tr>
					<td align="right" class="key">Grupo:</td>
					<td><input class="text_area" type="text" name="grupo" id="nome" size="5" maxlength="11" value="<?php echo htmlspecialchars(@$this->row->grupo) ?>" /></td>
				</tr>
				<tr>
					<td align="right" class="key">Ordem:</td>
					<td><input class="text_area" type="text" name="ordering" size="5" maxlength="11" value="<?= @$this->row->ordering?>" /></td>
				</tr>
				<tr>
					<td align="right" class="key">Publicado:</td>
					<td><?= $this->util('cadastro.published'); ?></td>
				</tr>
			</table>
		</fieldset>
	</div>

	<div class="clr"></div>

	<input type="hidden" name="idcomponente" value="<?= $idcomponente ?>" />
	<input type="hidden" name="idcadastro" value="<?= $idcadastro ?>" />
	<?= $this->util('cadastro.hiddens')?>

</form>
