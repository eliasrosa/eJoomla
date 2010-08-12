<?
$menu_principal->show();

jimport('edesktop.programas.produtos');

$dados = edProdutos::getInstance()
			->busca_todos_produtos()
			->andWhere('p.status != ?', -1)
			->createPager(null, 'edesktop');

?>
<h1>Lista de produtos</h1>
<p class="fl">Edite e remova produtos do sistema.</p>

<a href="javascript:void(0);" class="add link button fr" rel="'pagina':'produtos.form'">Adicionar novo</a>

<form rel="<?= $this->processID ?>" method="post" action="">
	<table class="ui-corner-top">
		<tr class="ui-widget-header">
			<td></td>
			<td style="width: 65px;">Imagem</td>
			<td>Nome</td>
			<td class="tac">Status</td>
		</tr>

	<? foreach($dados->pagerLayout->execute() as $p): ?>
		<tr class="ui-widget-content">
			<td><input type="checkbox" name="ids[]" value="<?= $p->id ?>" /></td>
			<td class="tac"><img src="<?= $p->imagem->url ?>" width="65" height="65" /></td>
			<td><strong><?= $p->nome ?></strong>
				<div class="actions">
					<span class="editar"><a class="link" rel="'pagina': 'produtos.form', 'query': 'id=<?= $p->id ?>'" href="javascript:void(<?= $p->id ?>);">Editar</a></span>
					<span class="excluir"><a href="javascript:void(<?= $p->id ?>);">Excluír</a></span>
					<span class="imagens"><a class="link" rel="'pagina':'imagens.lista', 'programa': 'produtos', 'processID': 'new', 'query': 'idproduto=<?= $p->id ?>'" href="javascript:void(<?= $p->id ?>);">Imagens</a></span>
					<span class="textos"><a class="link"  rel="'pagina':'textos.lista', 'programa': 'produtos', 'processID': 'new', 'query': 'idproduto=<?= $p->id ?>'" href="javascript:void(<?= $p->id ?>);">Textos</a></span>
				</div>
			</td>
			<td class="tac"><?= $dados->getImgStatus($p->status); ?></td>
		</tr>
	<? endforeach; ?>
	</table>
	<p class="fr"><?= $dados->pagerLayout->display() ?></p>
	<p class="excluir fl"><a href="javascript:void(0);">Excluír selecionados</a></p>
</form>
