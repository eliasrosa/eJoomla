<? defined('_JEXEC') or die('Acesso restrito'); ?>
<form action="index.php" method="post" name="adminForm">
	<div id="editcell">
		<table class="adminlist">
		<thead>
			<tr>
				<th width="5"><?= JText::_( 'ID' ); ?></th>
				<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?= count($this->itens); ?>);" /></th>
				<th width="150">Componente</th>
				<th>Label</th>
				<th width="100">Tipo</th>
				<th width="40" align="center">Ordem</th>
				<th width="20">Publicado</th>
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
				<td align="center"><?= $this->util('listagem.link', array('nome' => $row->componente, 'id'=> $row->idcomponente, 'view' => 'componentes')) ?></td>
				<td><?= $this->util('listagem.link', array('nome' => $row->nome, 'id'=> $id)) ?></td>
				<td align="center"><?= $row->tipo ?></td>
				<td align="center"><?= $row->ordering ?></td>
				<td align="center"><?= JHTML::_( 'grid.published', $row, $i ); ?></td>
			</tr>
			<? $k = 1 - $k;
		}
		?>
		</table>
	</div>
	<?= $this->util('listagem.hiddens') ?>
</form>
