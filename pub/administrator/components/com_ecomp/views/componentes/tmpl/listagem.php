<?php
defined('_JEXEC') or die('Acesso restrito');
?>
<form action="index.php" method="post" name="adminForm">
	<div id="editcell">
		<table class="adminlist">
		<thead>
			<tr>
				<th width="5">ID</th>
				<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?= count($this->itens); ?>);" /></th>
				<th>Componente</th>
				<th width="60" align="center">Publicado</th>
			</tr>
		</thead>
		<?php
		$k = 0;
		for ($i=0, $n=count($this->itens); $i < $n; $i++)
		{
			$row   =& $this->itens[$i];
			$id    = $row->id;
			?>
			<tr class="<?= "row$k"; ?>">
				<td align="center"><?= $id ?></td>
				<td align="center"><?= JHTML::_( 'grid.id', $i, $id ) ?></td>
				<td><?= $this->util('listagem.link', array('nome' => $row->nome, 'id' => $id, 'task' => 'edit')) ?></td>
				<td align="center"><?= JHTML::_( 'grid.published', $row, $i ); ?></td>
			</tr>
			<? $k = 1 - $k;
		}
		?>
		</table>
	</div>
	<?= $this->util('listagem.hiddens') ?>
</form>
