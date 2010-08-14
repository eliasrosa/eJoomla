<?
$menu_principal->show();

jimport('edesktop.programas.produtos');

$finder = JRequest::getVar('finder', false);

if($finder)
	$dados = edProdutos::getInstance()
				->busca_produtos_por_search($finder)
				->createPager(null, 'edesktop');
else
	$dados = edProdutos::getInstance()
				->busca_todos_produtos()
				->andWhere('p.status != ?', -1)
				->createPager(null, 'edesktop');

$produtos = $dados->pagerLayout->execute();				

?>
<h1>Lista de produtos</h1>
<p class="fl">Edite e remova produtos do sistema.
<br/>Encontrado <?= $dados->pager->getNumResults() ?> produto(s)</p>

<a href="javascript:void(0);" class="add link button fr" rel="'pagina':'produtos.form'">Adicionar novo</a>

<form rel="<?= $this->processID ?>" method="post" action="">
	<table class="ui-corner-top">
		<tr class="ui-widget-header">
			<td></td>
			<td style="width: 65px;">Imagem</td>
			<td>Nome</td>
			<td class="tac">Status</td>
		</tr>

	<? foreach($produtos as $p): ?>
		<tr class="ui-widget-content">
			<td><input type="checkbox" name="ids[]" value="<?= $p->id ?>" /></td>
			<td><span class="img1"><img src="<?= $p->imagem->url ?>" width="65" height="65" /></span></td>
			<td><strong><?= $p->nome ?></strong>
				<div class="actions">
					<span class="editar"><a class="link" rel="'pagina': 'produtos.form', 'programa': 'produtos', 'processID': 'new', 'query': 'id=<?= $p->id ?>'" href="javascript:void(<?= $p->id ?>);">Editar</a></span>
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
