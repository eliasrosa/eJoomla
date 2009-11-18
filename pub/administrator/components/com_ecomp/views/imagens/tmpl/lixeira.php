<?php
defined('_JEXEC') or die('Acesso restrito');

$idcomponente = JRequest::getVar('idcomponente', 0);
$idcadastro   = JRequest::getVar('idcadastro', 0);

// pega o alias do campo da tabela do componente
$campo = new JCRUD(ECOMP_TABLE_CAMPOS);
$campo = $campo->busca("WHERE idcomponente = '{$idcomponente}' AND published = '1' ORDER BY ordering ASC LIMIT 0,1");
$campo = $campo[0]->alias;

// pega o alias da tabela do componente
$componente = new JCRUD(ECOMP_TABLE_COMPONENTES, array('id' => $idcomponente));
$componente = $componente->alias;

// pega o titilo do cadastro
$cadastro = new JCRUD(ECOMP_TABLE_COMPONENTES."_{$componente}", array('id' => $idcadastro));

echo "<h1><small>{$cadastro->$campo}</small></h1>"
?>
<form action="index.php" method="post" name="adminForm">
	<div id="editcell">
		<table class="adminlist">
		<thead>
			<tr>
				<th width="5">ID</th>
				<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?= count($this->itens); ?>);" /></th>
				<th>Legenda</th>
				<th width="60">Imagem</th>
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
				<td><?= $this->util('listagem.link', array('nome' => ($row->legenda ? stripslashes($row->legenda) : '-- sem legenda --'), 'id' => $id, 'task' => 'unTrash', 'idcomponente' => $idcomponente, 'idcadastro' => $idcadastro )) ?></td>
				<td><img src="../images/com_ecomp/<?= $idcomponente.'/'.$idcadastro.'/'.str_replace('.', '_p.', $row->file) ?>" /></td>
			</tr>
			<? $k = 1 - $k;
		}
		?>
		</table>
	</div>
	<input type="hidden" name="idcomponente" value="<?= $idcomponente ?>" />
	<input type="hidden" name="idcadastro" value="<?= $idcadastro ?>" />
	<?= $this->util('listagem.hiddens') ?>
</form>
