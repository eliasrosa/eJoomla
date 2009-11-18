<?php
defined('_JEXEC') or die('Acesso restrito');

$idcomponente = JRequest::getVar('idcomponente', 0);

function nivelspaco($n, $s)
{
	$r = '';
	for($i=0; $i < $n; $i++ )
		$r = $r . $s;

	return $r;
}

function linhas($array, $nivel, $util)
{
	global $id_cid;
	foreach ($array as $row)
	{
		if(is_object($row))
		{
			$id = $row->id;
			$id_cid++;
			?>
			<tr class="<?= "row{$id}"; ?>">
				<td align="center"><?= $id ?></td>
				<td align="center"><?= JHTML::_( 'grid.id', $id, $id) ?></td>
				<td><?= nivelspaco($nivel, '-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;') . $util->util('listagem.link', array('nome' => $row->nome, 'id'=> $id, 'idcomponente' => JRequest::getVar('idcomponente'))) ?></td>
				<td align="center"><?= $row->ordering ?></td>
				<td align="center"><?= JHTML::_( 'grid.published', $row, $id ); ?></td>
			</tr>
			<?
		}

		if(is_array($row))
		{
			linhas($row, $nivel + 1, $util);
		}
	}

}

?>
<form action="index.php" method="post" name="adminForm">
	<div id="editcell">
		<table class="adminlist">
		<thead>
			<tr>
				<th width="5"><?= JText::_( 'ID' ); ?></th>
				<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?= count($this->itens); ?>);" /></th>
				<th><?= JText::_( 'Nome' ); ?></th>
				<th width="60" align="center"><?= JText::_( 'Ordem' ); ?></th>
				<th width="60" align="center">Publicado</th>
			</tr>
		</thead>
		<?php
			$id_cid = 0;
			linhas($this->itens, 0, $this);
		?>
		</table>
		<br /><span style="color: #AAA;"><a href="index.php?option=com_ecomp&view=cadastros&idcomponente=<?= $idcomponente ?>">Cadastros</a> | <a href="index.php?option=com_ecomp&view=categorias&idcomponente=<?= $idcomponente ?>">Categorias</a></span>
	</div>
	<input type="hidden" name="idcomponente" value="<?= $idcomponente ?>" />
	<?= $this->util('listagem.hiddens') ?>
</form>
