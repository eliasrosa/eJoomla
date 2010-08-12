<?php
defined('_JEXEC') or die( "Acesso Restrito" );

// importa a class loja
jimport('edesktop.programas.loja');


$mid = $params->get('mod_id');
$tit = $params->get('mod_titulo');
$cid = $params->get('mod_categoriaID');
$lim = $params->get('mod_limit');

$iid = edLoja::getInstance()->itemid;

// adiciona o style css da loja
JHTML::stylesheet('style.css', 'media/com_edesktop/loja/css/');


// carrega dados
$dados = edProdutos::getInstance()
			->busca_produtos_ativos_por_categoria($cid)
			->getQuery()
			->limit($lim)
			->orderBy('rand()')
			->execute();
			
?>

<div id="<?= $mid ?>" class="modEdesktopProduto">
	<?= $module->showtitle ? "<h2>$tit</h2>" : ""; ?>	
	<div class="produtos">
		<?
		foreach($dados as $p)
		 echo edLoja::getInstance()->getProdutoHtml($p); ?>
	</div>
</div>
