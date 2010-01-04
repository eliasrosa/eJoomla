<?php
defined('_JEXEC') or die( "Acesso Restrito" );
jimport('joomla.event.plugin');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

require_once(JPATH_ROOT.DS.'media'.DS.'plg_eload'.DS.'class'.DS.'eload.helper.php');

class PLGSYSTEMeload extends JPlugin
{
	var $_plugin,
		$_params,
		$_head,
		$_doc,
		$_mediaDir,
		$_mediaUrl,
		$_html;

	var $_nome  = 'eload';
	var $_cache = 'cache/eload';

	function onAfterDispatch()
	{
		// ser for admin
		global $mainframe;
		if ($mainframe->isAdmin()) return;
		
		// verivica se existe a pasta cache
		if(!is_dir('cache')) @mkdir('cache');
		if(!is_dir($this->_cache)) @mkdir($this->_cache);		

		// carrega o parametros
		$this->_plugin = JPluginHelper::getPlugin( 'system', $this->_nome );
		$this->_params = new JParameter( $this->_plugin->params );

		// carrega document
		$this->_doc  =& JFactory::getDocument();

		// carrega o head
		$this->_head =  $this->_doc->getHeadData();

		// pasta media
		$this->_mediaDir = sprintf('media'.DS.'plg_%s'.DS, $this->_nome);

		// absolute path media dir
		$this->_mediaUrl = JURI::base(1).'/'.sprintf('media/plg_%s/', $this->_nome);

		// Mootools
		$this->Mootools();

		// jQuery
		$this->jQuery();

		// altera o head do Mootools/jQuery
		$this->_doc->setHeadData($this->_head);

		// altera o título
		$this->titulo();

		// adiciona head do litebox
		$this->lightbox_adicionar_scripts();

		// adiciona o FireBug Lite
		$this->firebug_adicionar_scripts();

		return true;
	}

	function onAfterRender()
	{
		// ser for admin
		global $mainframe;
		if ($mainframe->isAdmin()) return;

		// pega o html
		$this->_html = JResponse::getBody();

		// arruma todas imgs
		$this->prepara_imagens();

		// Substitui {eimage}
		$this->eimage_replace();

		// cria os litebox
		$this->lightbox_search();

		// remove o tag meta generator
		$this->generator();

		// grava o html
		JResponse::setBody($this->_html);

		// adiciona o Google Analytics
		$this->analytics_adicionar_scripts();

	}


////////////////////////////////////////////////////////////////////
// FUNCTIONS
////////////////////////////////////////////////////////////////////
	private function Mootools()
	{
		reset($this->_head['scripts']);

		foreach($this->_head['scripts'] as $key=>$value){

			// removeMootools
			if($this->_params->get('removeMootools') && strpos($key,'mootools.js'))
				unset($this->_head['scripts'][$key]);

			// removeMootools-uncompressed
			if($this->_params->get('removeMootoolsUncompressed') && strpos($key,'mootools-uncompressed.js'))
				unset($this->_head['scripts'][$key]);

			// removeCaption
			if($this->_params->get('removeCaption') && strpos($key,'caption.js'))
				unset($this->_head['scripts'][$key]);
		}

		return;
	}

	private function jQuery()
	{
		if($this->_params->get('addJquery'))
		{
			// cria um array
			$newscript = array();

			// pega a versão do jquery selecionado
			$file = $this->_params->get('versionJquery').'/jquery.min.js';
			
			// adiciona na array
			$newscript['http://ajax.googleapis.com/ajax/libs/jquery/'. $file] = 'text/javascript';
			
			// atualiza os scripts do frontend
			$this->_head['scripts'] = array_merge($newscript, $this->_head['scripts']);
		}

	}

	private function titulo()
	{
		global $mainframe;

		if($this->_params->get('titulo'))
		{
			// nome do site
			$siteName = $mainframe->getCfg('sitename');

			// titulo da página
			$pagiName = $this->_doc->getTitle();

			// pega o param
			$newTitle = $this->_params->get('tituloSite');

			// altera a variavel
			$newTitle = str_replace('{sitename}', $siteName, $newTitle);

			// altera a variavel
			$newTitle = str_replace('{title}', $pagiName, $newTitle);

			// set o novo título
			$this->_doc->setTitle($newTitle);
		}

		return true;
	}

	function prepara_imagens()
	{
		$html = $this->_html;

		$regExp = array();

		// nehuma imagem
		$regExp[1] = false;

		// todas as tags IMG
		$regExp[2] = '/<img[^>]*>/';

		// somente as imagens com a class abaixo
		$regExp[3] = sprintf('/<img .*?class=".*?\b%s\b.*?" \/>/i', $this->_params->get('eImageResizeClass'));

		$filtro = $this->_params->get('eImageResizeAll');

		// existir o filtro
		if(isset($regExp[$filtro]) or $regExp[$filtro])
		{
			// captura todas as tag img do artigo
			preg_match_all($regExp[$filtro], $html, $resultado);

			// se encontrar uma imagem
			if(is_array($resultado[0]))
				// redimenciona a imagem
				$this->eimage_resize($resultado[0]);
		}
		return;
	}

	private function eimage_resize($imagens)
	{
		if(is_array($imagens))
		{
			$html = $this->_html;

			foreach($imagens as $img)
			{
				// verifica se a tag img tem a class eImageNoResizeClass
				$regExp = sprintf('/class=".*?\b%s\b.*?"/i', $this->_params->get('eImageNoResizeClass'));
				preg_match_all($regExp, $img, $noResize);
		
				if(!isset($noResize[0][0]))
				{
									
					// captura o height
					preg_match_all('#height="(.+?)"#', $img, $height);

					// captura o weidth
					preg_match_all('#width="(.+?)"#', $img, $width);

					// captura o src
					preg_match_all('#src="(.+?)"#', $img, $src);

					$largura = isset($width[1][0]) ? $width[1][0] : null;
					$altura  = isset($height[1][0]) ? $height[1][0] : null;
	
					if (isset($src[1][0]) && (!is_null($largura) || !is_null($altura)))
					{
												
						// cria a nova img no pasta cache
						$newpath = eLoadHelper::cria_imagem($src[1][0], $largura, $altura);

						// altera o SRC da imagem
						$newimg = str_replace($src[0][0], 'src="'.$newpath.'"' , $img);

						// remove o attr height
						if (!is_null($largura))
							$newimg = str_replace(@$height[0][0], '', $newimg);

						// remove o attr width
						if (!is_null($altura))
							$newimg = str_replace(@$width[0][0], '', $newimg);

						// atualiza o artigo
						$html = str_replace($img, $newimg, $html);
					}
				}
			}
			// atualiza o html
			$this->_html = $html;
		}
		return;
	}

	private function eimage_replace()
	{
		$html = $this->_html;

		$regExp = '/\[eimage .*?\]/i';

		// captura todas as tag img do artigo
		preg_match_all($regExp, $html, $resultado);

		// se encontrar uma imagem
		if(is_array($resultado[0]))
		{
			$imagens = $resultado[0];

			foreach($imagens as $img)
			{
				// captura o height
				preg_match_all("#height='(.+?)'#", $img, $height);

				// captura o weidth
				preg_match_all("#width='(.+?)'#", $img, $width);

				// captura o src
				preg_match_all("#src='(.+?)'#", $img, $src);

				// captura o fir
				preg_match_all("#fit='(.+?)'#", $img, $fit);
				$fit = @$fit[1][0] == 'inside' ? 'inside' : @$fit[1][0];

				// captura o scale
				preg_match_all("#scale='(.+?)'#", $img, $scale);
				$scale = @$scale[1][0] == 'any' ? 'any' : @$scale[1][0];
				
				// captura o attr watermarks p/ marca d'águas
				preg_match_all("#watermarks='(.+?)'#", $img, $watermarks);

				// sem marca d'água por padrão
				$wm = false;

				// se existir alguma marca d'água
				if(isset($watermarks[1][0]))
					$wm = eLoadHelper::watermark_info($watermarks[1][0]);			
				

				// cria a nova img no pasta cache
				$newpath = eLoadHelper::cria_imagem(@$src[1][0], @$width[1][0], @$height[1][0], $fit, $scale, $wm);

				// atualiza o artigo
				$html = str_replace($img, $newpath, $html);
			}
			// atualiza o html
			$this->_html = $html;
		}
		return;
	}

	private function lightbox_search()
	{
		$html = $this->_html;
		$className = $this->_params->get('lightBox-class');

		// captura todas as tag a com a class eimagebox
		$exp = sprintf('/<a .*?rel=".*?\b%s\b.*?">/i', $className);
		preg_match_all($exp, $html, $resultado);

		foreach($resultado[0] as $link)
		{
			// captura o attr tabindex
			$exp = '#tabindex="(.+?)"#';
			preg_match_all($exp, $link, $tabindex);

			if(isset($tabindex[0][0]))
			{
				// remove o attr tabindex
				$newlink = str_replace($tabindex[0][0], '', $link);

				// altera o link do artigo
				$html = str_replace($link, $newlink, $html);

				// atualiza o link
				$link = $newlink;
			}


			// se existir alguma classe
			if(isset($tabindex[1][0]))
			{
				list($largura, $altura) = explode(',', $tabindex[1][0]);

				$largura = $largura != '0' ? $largura : null;
				$altura  = $altura  != '0' ? $altura  : null;
			}
			else
			{
				$largura = null;
				$altura  = null;
			}

			// captura o attr watermarks p/ marca d'águas
			$exp = '#watermarks="(.+?)"#';
			preg_match_all($exp, $link, $watermarks);

			if(isset($watermarks[0][0]))
			{
				// remove o attr watermarks
				$newlink = str_replace($watermarks[0][0], '', $link);

				// altera o link do artigo
				$html = str_replace($link, $newlink, $html);

				// atualiza o link
				$link = $newlink;
			}


			// sem marca d'água por padrão
			$wm = false;

			// se existir alguma marca d'água
			if(isset($watermarks[1][0]))
				$wm = eLoadHelper::watermark_info($watermarks[1][0]);

			// captura o attr href
			$exp = '#href="(.+?)"#';
			preg_match_all($exp, $link, $href);

			// se existir alguma classe
			if(isset($href[1][0]))
			{
				$href = $href[1][0];

				// cria a imagem
				$src = eLoadHelper::cria_imagem($href, $largura, $altura, 'inside', 'any', $wm);

				//altera o href
				$newlink = str_replace($href, $src, $link);

				// altera o link do artigo
				$html = str_replace($link, $newlink, $html);

				//
				$this->_html = $html;
			}
		}
	}

	function lightbox_adicionar_scripts()
	{
		if($this->_params->get('lightBox-active'))
		{
			$doc  = & JFactory::getDocument();
			$doc->addScript($this->_mediaUrl . 'js/jquery.slimbox2.js');
			$doc->addStyleSheet($this->_mediaUrl . 'css/jquery.slimbox2.css');

			$jsDeclaration = sprintf('jQuery(function(a){a("a[rel^=\'lightbox\']").slimbox({overlayOpacity: %s, counterText: \'%s {x} %s {y}\'},null,function(b){return(this==b)||((this.rel.length>8)&&(this.rel==b.rel))})});',
				$this->_params->get('lightBox-overlayOpacity'),
				$this->_params->get('lightBox-txtImage'),
				$this->_params->get('lightBox-txtOf')
			);

			$doc->addScriptDeclaration($jsDeclaration);

		}

		return;
	}



	////////////////////////////////////////////////////////////////////
	// FIREBUG LITE
	////////////////////////////////////////////////////////////////////

	/* Caso o parametro esteja ativado, adiciona o FireBug Lite 1.2
	 * @return void
	 */
	function firebug_adicionar_scripts()
	{
		if($this->_params->get('firebug-adicionar') == '1')
		{
			$doc = & JFactory::getDocument();
			$doc->addScript('http://getfirebug.com/releases/lite/1.2/firebug-lite-compressed.js');
		}
	}




	////////////////////////////////////////////////////////////////////
	// GOOGLE ANALYTICS
	////////////////////////////////////////////////////////////////////

	/* Caso o parametro esteja ativado, adiciona o Google Analytics
	 * @return void
	 */
	function analytics_adicionar_scripts()
	{
		global $mainframe;

		if($this->params->get('analytics-adicionar') == '1')
		{
			$ID = $this->params->get('analytics-UA');

			if($mainframe->isAdmin() || strpos($_SERVER["PHP_SELF"], "index.php") === false)
				return;

			$buffer = JResponse::getBody();

			$javascript = '
				<script type="text/javascript">
				var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
				document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
				</script>
				<script type="text/javascript">
				try {
				var pageTracker = _gat._getTracker("'.$ID.'");
				pageTracker._trackPageview();
				} catch(err) {}</script>
				'."\n";


			if($ID == '')
				$javascript = '<div style="position: fixed; top: 0; text-align: center; font-weight: 700; width: 100%; padding: 5px; background-color: #FF0000; color: #FFF; font-size: 12px; ">Plugin eLoad: ID da propriedade da web do Google Analytics não está definida!</div>';

			$pos = strrpos($buffer, "</body>");

			if($pos > 0)
			{
				$buffer = substr($buffer, 0, $pos).$javascript.substr($buffer, $pos);
				JResponse::setBody($buffer);
			}
		}

		return;
	}


	////////////////////////////////////////////////////////////////////
	// GENERATOR
	////////////////////////////////////////////////////////////////////

	/* Caso o parametro esteja ativado, remove a tag meta generator
	 * @return void
	 */
	function generator()
	{
		if($this->_params->get('generator') == '1')
		{
			$this->_html = preg_replace('#<meta name="generator" .* />.*<title>#s', '<title>', $this->_html);
		}
	}

}
?>
