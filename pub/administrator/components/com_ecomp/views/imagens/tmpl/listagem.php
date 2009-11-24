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

// Adiciona o script do swfobject, script e css do multiUpload
$doc = & JFactory::getDocument();
$doc->addScript('http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js');
$doc->addScript(ECOMP_URL_MEDIA . 'js/multiUpload.js');
$doc->addStyleSheet(ECOMP_URL_MEDIA . 'css/multiUpload_admin.css');

echo "<h1><small>{$cadastro->$campo}</small></h1>";
?>
<div id="uploader"></div><br /><br />
<div id="uploader_files"></div>
<br style="clear:both" />
<div class="upload_actions"><a href="javascript:uploader.startUpload();">Enviar</a> &nbsp;|&nbsp; <a href="javascript:uploader.clearUploadQueue();">Limpar/Cancelar todos os downloads</a></div>
<br />

<script type="text/javascript">
var uploader = new multiUpload('uploader', 'uploader_files', {
	swf:             '<?php echo ECOMP_URL_MEDIA ?>swf/multiUpload.swf',
	width:           190,
	height:          32,
	script:          'index.php',
	multi:           true,
	data:            {
		option: 'com_ecomp',
		view: 'imagens',
		task: 'save',
		published: '1',
		js: '1',
		idcomponente: <?php echo $idcomponente ?>,
		idcadastro: <?php echo $idcadastro ?>,
		sid: '<?php echo session_id() ?>'
	},
	fileDescription: 'Imagens',
	fileExtensions:  '*.jpg;*.jpeg;*.gif;*.png',
	onAllComplete:   function()
	{
		if (confirm("Todos os arquivos foram enviados. Deseja atualizar a página?"))
			window.location.reload(false);
	}
});
</script>

<form action="index.php" method="post" name="adminForm">
	<div id="editcell">
		<table class="adminlist">
		<thead>
			<tr>
				<th width="5">ID</th>
				<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?= count($this->itens); ?>);" /></th>
				<th>Legenda</th>
				<th width="40" align="center">Ordem</th>
				<th width="20">Publicado</th>
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
				<td><?= $this->util('listagem.link', array('nome' => ($row->legenda ? stripslashes($row->legenda) : '-- sem legenda --'), 'id' => $id, 'task' => 'edit', 'idcomponente' => $idcomponente, 'idcadastro' => $idcadastro )) ?></td>
				<td align="center"><?= $row->ordering ?></td>
				<td align="center"><?= JHTML::_( 'grid.published', $row, $i ); ?></td>
				<td><img src="../<?= ECOMP_URL_IMAGENS .'/'. $row->id.'_p.jpg' ?>" /></td>
			</tr>
			<? $k = 1 - $k;
		}
		?>
		</table>
		<br /><a href="index.php?option=com_ecomp&view=cadastros&idcomponente=<?= $idcomponente ?>">Cadastros</a>
	</div>
	<input type="hidden" name="idcomponente" value="<?= $idcomponente ?>" />
	<input type="hidden" name="idcadastro" value="<?= $idcadastro ?>" />
	<?= $this->util('listagem.hiddens') ?>
</form>
