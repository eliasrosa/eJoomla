<?php
defined('_JEXEC') or die('Acesso restrito');

$idcomponente = JRequest::getVar('idcomponente', 0);
$campo = new JCRUD(ECOMP_TABLE_CAMPOS);
$campo = $campo->busca("WHERE idcomponente = '{$idcomponente}' AND published = '1' ORDER BY ordering ASC LIMIT 0,1");
if(count($campo)){
	$campo = array_shift($campo);
	$alias = $campo->alias;
?>
<form action="index.php" method="post" name="adminForm">
	<div id="editcell">
		<table class="adminlist">
		<thead>
			<tr>
				<th width="5">ID</th>
				<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?= count($this->itens); ?>);" /></th>
				<th><? echo $campo->nome; ?></th>
				<th width="80" align="center">Imagens</th>
				<th width="60" align="center">Ordem</th>
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
			<tr class="<?= "row{$id}"; ?>">
				<td align="center"><?= $id ?></td>
				<td align="center"><?= JHTML::_( 'grid.id', $id, $id ) ?></td>
				<td>
				<?php

				$nome = $row->$alias;

				if($campo->idtipo == 8)
				{
					parse_str($campo->params, $params);

					$componente = new JCRUD(ECOMP_TABLE_COMPONENTES, array( 'id' => $params['idcomponente']));
					$coluna     = new JCRUD(ECOMP_TABLE_CAMPOS, array( 'id' => $params['idcampo']));

					$componente = new JCRUD(ECOMP_TABLE_COMPONENTES.'_'.$componente->alias, array( 'id' => $row->$alias));

					$alias_coluna = $coluna->alias;

					$nome = $componente->$alias_coluna;
				}

				echo $this->util('listagem.link', array('nome' => $nome, 'id'=> $id, 'idcomponente' => $idcomponente));

				 ?><br />
					<span style="font-size: 9px; color: #AAA;"><b>Categorias:</b> | <b>Tags:</b></span>
				</td>
				<td align="center"><? echo $this->util('listagem.link', array('nome' => 'Administrar imagens', 'id'=> $id, 'idcadastro'=> $id, 'task' => '', 'view' => 'imagens', 'idcomponente' => $idcomponente)); ?></td>
				<td align="center"><?= $row->ordering ?></td>
				<td align="center"><?= JHTML::_('grid.published', $row, $id ); ?></td>
			</tr>
			<? $k = 1 - $k;
		}
		?>
		</table>
		<br /><span style="color: #AAA;"><a href="index.php?option=com_ecomp&view=categorias&idcomponente=<?= $idcomponente ?>">Categorias</a> | <a href="index.php?option=com_ecomp&view=tags&idcomponente=<?= $idcomponente ?>">Tags</a></span>
	</div>
	<input type="hidden" name="idcomponente" value="<?= $idcomponente ?>" />
	<?= $this->util('listagem.hiddens') ?>
</form>
<? }else{ ?>
<p>Nenhum campo foi cadastrado ou está ativo para esse componente, <a href="index.php?option=com_ecomp&view=campos">clique aqui para cadastrar</a></p>
<? } ?>
