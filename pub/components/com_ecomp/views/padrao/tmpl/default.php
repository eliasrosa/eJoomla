<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

// inicio o smarty
$smarty = new Smarty();
$smarty->template_dir = ECOMP_PATH_SMARTY_TEMPLATE;
$smarty->compile_dir  = ECOMP_PATH_SMARTY_COPILE;
$smarty->cache_dir    = ECOMP_PATH_SMARTY_CACHE;


// carrega as variaveis padrao
$id           = JRequest::getInt('id', 0);
$idcategoria  = JRequest::getInt('idcategoria', 0);
$idcomponente = $this->params->get('idcomponente');
$tipo         = $this->params->get('tipo');
$classes      = $this->params->get('classes');
$titulo       = $this->params->get('titulo');
$pasta        = $this->params->get('pasta');
$arquivo      = $this->params->get('arquivo');
$doc          =& JFactory::getDocument();
$html         = '';


// arquivos
$file_js  = ECOMP_PATH_TEMPLATE.DS.$pasta.DS. $arquivo.$tipo.'.js';
$file_css = ECOMP_PATH_TEMPLATE.DS.$pasta.DS. $arquivo.$tipo.'.css';
$file_php = ECOMP_PATH_TEMPLATE.DS.$pasta.DS. $arquivo.$tipo.'.php';


// nome da tebela do componente
$tabela       = eHelper::componente_tabela_nome($idcomponente);


// envia vars para o template
$smarty->assign('classes',            $classes);
$smarty->assign('titulo',             $titulo);
$smarty->assign('ECOMP_URL_TEMPLATE', ECOMP_URL_TEMPLATE);
$smarty->assign('ECOMP_URL_UPLOADS',  ECOMP_URL_UPLOADS);
$smarty->assign('ECOMP_URL_IMAGES',   ECOMP_URL_IMAGES);
$smarty->assign('ECOMP_URL_MEDIA',    ECOMP_URL_MEDIA);


// tenta abrir o js
if(file_exists($file_js))
	$doc->addScript($file_js);


// tenta abrir o css
if(file_exists($file_css))
	$doc->addStyleSheet($file_css);


// tenta abrir o php
if(file_exists($file_php)) require($file_php);
else
{
	// abre os cadastros
	$cadastros = new JCRUD($tabela);
	$cadastros = $cadastros->busca("WHERE trashed != '1' AND published = '1' ORDER BY ordering ASC");
}


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



?>
