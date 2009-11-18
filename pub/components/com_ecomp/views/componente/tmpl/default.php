<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

// carrega as variaveis padrao
$idcomponente = JRequest::getInt('id', 0);
$idcategoria  = JRequest::getInt('idcategoria', 0);
$limit        = JRequest::getInt('limit', 0);

// pega dados do componente
$componente = new JCRUD(ECOMP_TABLE_COMPONENTES);
$componente = $componente->busca("WHERE id = '{$idcomponente}' AND trashed != '1' AND published = '1'");

// verifica se o componente foi encontrado
if(!count($componente)) return;

// carrega o objeto
$componente = array_shift($componente);

// template
$template = !$this->params->get('template') ? $componente->alias : $this->params->get('template');

// classes
$classes = "ecomp {$componente->alias}" . ($this->params->get('classes')? ' '.$this->params->get('classes') : '');

// título
$titulo = !$this->params->get('titulo') ? $componente->nome : $this->params->get('titulo');

// Nome da tabela
$tabela = ECOMP_TABLE_COMPONENTES."_{$componente->alias}";

// inicio o smarty
$smarty = new Smarty();
$smarty->template_dir = ECOMP_PATH_SMARTY_TEMPLATE;
$smarty->compile_dir  = ECOMP_PATH_SMARTY_COPILE;
$smarty->cache_dir    = ECOMP_PATH_SMARTY_CACHE;

$smarty->assign('classes', $classes);
$smarty->assign('titulo', $titulo);

$smarty->assign('url_uploads', ECOMP_URL_UPLOADS);
$smarty->assign('componente', $componente);
$smarty->assign('idcategoria', $idcategoria);

// tenta abrir o php
if(file_exists(ECOMP_PATH_SMARTY_TEMPLATE.DS."{$template}_lista.php"))
	require(ECOMP_PATH_SMARTY_TEMPLATE.DS."{$template}_lista.php");
else
{
	// abre os cadastros
	$cadastros = new JCRUD($tabela);
	$cadastros = $cadastros->busca("WHERE trashed != '1' AND published = '1' ORDER BY ordering ASC");
}

// inicia a variavel
$html = '';

// abre o topo
if(file_exists(ECOMP_PATH_SMARTY_TEMPLATE.DS."{$template}_lista_topo.html"))
	$html .= $smarty->fetch("{$template}_lista_topo.html");
elseif(file_exists(ECOMP_PATH_SMARTY_TEMPLATE.DS."ecomppadrao_lista_topo.html"))
	$html .= $smarty->fetch("ecomppadrao_lista_topo.html");
else
	$html .= '<div class="'.$classes.'"><h3 class="tit"><span>'.$titulo.'</span></h3>';


if (is_array($cadastros) && count($cadastros) > 0)
{
	foreach($cadastros as $cadastro)
	{
		// adiciona um view ao item
		//$cadastro->view_lista++;
		//$cadastro->update();

		$idcadastro = $cadastro->id;

		// pega as imagens do cadastro
		$imagens = new JCRUD(ECOMP_TABLE_CADASTROS_IMAGENS);
		$imagens = $imagens->busca("WHERE idcomponente = '{$idcomponente}' AND idcadastro = '{$idcadastro}' AND trashed != '1' AND published = '1' ORDER BY ordering ASC");

		// carrega a imagem com o caminho completo
		foreach($imagens as $k=>$v)
		{
			$imagens[$k]->file = ECOMP_URL_IMAGES."/{$idcomponente}/{$idcadastro}/".$imagens[$k]->file;
		}

		$smarty->assign('dados', $cadastro);
		$smarty->assign('imagens', $imagens);
		$smarty->assign('path_uploads', ECOMP_URL_UPLOADS."/{$idcomponente}/{$idcadastro}");
		$smarty->assign('path_images_uploads', ECOMP_URL_IMAGES."/uploads/{$idcomponente}/{$idcadastro}");

		// abre o meio
		$html .= $smarty->fetch("{$template}_lista.html");
	}
}
else
{
	// abre o rodape
	if(file_exists(ECOMP_PATH_SMARTY_TEMPLATE.DS."{$template}_lista_nada.html"))
		$html .= $smarty->fetch("{$template}_lista_nada.html");
	elseif(file_exists(ECOMP_PATH_SMARTY_TEMPLATE.DS."ecomppadrao_lista_nada.html"))
		$html .= $smarty->fetch("ecomppadrao_lista_nada.html");
	else
		$html .= '<p>Nenhum item encontrado.</p>';
}

// abre o rodape
if(file_exists(ECOMP_PATH_SMARTY_TEMPLATE.DS."{$template}_lista_rodape.html"))
	$html .= $smarty->fetch("{$template}_lista_rodape.html");
elseif(file_exists(ECOMP_PATH_SMARTY_TEMPLATE.DS."ecomppadrao_lista_rodape.html"))
	$html .= $smarty->fetch("ecomppadrao_lista_rodape.html");
else
	$html .= '</div>';


// exibe o html
echo $html;

$doc  = & JFactory::getDocument();

// tenta abrir o js
if(file_exists(ECOMP_PATH_TEMPLATE."/js/{$template}.js"))
	$doc->addScript(ECOMP_URL_TEMPLATE."/js/{$template}.js");

// tenta abrir o css
if(file_exists(ECOMP_PATH_TEMPLATE."/css/{$template}.css"))
	$doc->addStyleSheet(ECOMP_URL_TEMPLATE."/css/{$template}.css");


?>
