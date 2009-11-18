<?php
defined('_JEXEC') or die('Acesso restrito');

$idcomponente = JRequest::getVar('idcomponente', 0);
$campo = new JCRUD(ECOMP_TABLE_CAMPOS);
$campo = $campo->busca("WHERE idcomponente = '{$idcomponente}' AND published = '1' ORDER BY ordering ASC LIMIT 0,1");
if(count($campo)){
?>
<form action="index.php" method="post" name="adminForm">
	<div id="editcell">
		<table class="adminlist">
		<thead>
			<tr>
				<th width="5">ID</th>
				<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?= count($this->itens); ?>);" /></th>
				<th>
					<?
						$alias = $campo[0]->alias;
						echo $campo[0]->nome;
					?>
				</th>
			</tr>
		</thead>
		<?php
		$k = 0;
		for ($i=0, $n=count($this->itens); $i < $n; $i++)
		{
			$row   =& $this->itens[$i];
			$id    = $row->id;

			?>
			<tr class="<?= "row{$id}"; ?>">
				<td align="center"><?= $id ?></td>
				<td align="center"><?= JHTML::_( 'grid.id', $id, $id ) ?></td>
				<td><?php echo $this->util('listagem.link', array('nome' => $row->$alias, 'id'=> $id, 'idcomponente' => $idcomponente, 'task' => 'unTrash')); ?><br />
					<span style="font-size: 9px; color: #AAA;"><b>Categorias:</b> | <b>Tags:</b></span>
				</td>
			</tr>
			<? $k = 1 - $k;
		}
		?>
		</table>
	</div>
	<input type="hidden" name="idcomponente" value="<?= $idcomponente ?>" />
	<?= $this->util('listagem.hiddens') ?>
</form>
<? }else{ ?>
<p>Nenhum campo foi cadastrado ou está ativo para esse componente, <a href="index.php?option=com_ecomp&view=campos">clique aqui para cadastrar</a></p>
<? } ?>
