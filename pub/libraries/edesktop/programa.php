<?
// no direct access
defined('_JEXEC') or die('Restricted access');

class programa {

    private $__vars = array();

    private function __get($nome) {
        return $this->__vars[$nome];
    }

    private function __set($nome, $valor) {
        $this->__vars[$nome] = $valor;
    }

    public function __construct() {
        // get token
        JRequest::checkToken('request') or jexit( 'eDeskop: Invalid Token' );

        // pega o token
        $this->token = EDESKTOP_TOKEN;

        // template do sistema
        $this->template = JRequest::getvar('template', 'edesktop');

        // pasta do programa
        $this->programa = JRequest::getvar('programa');

        // pagina do programa
        $this->pagina = JRequest::getvar('pagina', 'index');

        // carregar pagina
        $this->funcao = JRequest::getvar('funcao', 1);

        // url base
        $this->url_base = EDESKTOP_URL;

        // url do programa
        $this->url_programa = EDESKTOP_URL .'/programas/'. $this->programa;

        // id do procedo
        $this->processID = JRequest::getvar('processID', false);

        // pasta do programa
        $this->pasta = EDESKTOP_PATH_PROGRAMAS .DS. $this->programa;

        // pasta das paginas
        $this->pasta_paginas = $this->pasta .DS. 'paginas';

        // carrega a class JCRUD
        jimport('edesktop.jcrud');

        // carrega a class smarty
		jimport('edesktop.smarty.class');

        // inicio o smarty
        $this->smarty = new Smarty();
        $this->smarty->compile_dir  = EDESKTOP_PATH_SMARTY_COPILE;
        $this->smarty->cache_dir    = EDESKTOP_PATH_SMARTY_CACHE;

    }

    public function get_config($programa, $json = false, $veriFinder = true) {
        $file = EDESKTOP_PATH_PROGRAMAS .DS. $programa .DS. 'configuracoes.php';

        if(file_exists($file)) {
            require($file);

            // configurações padrões
            $padrao =  array(
                // Titulo do programa
                'titulo' => 'Programa sem título',

                // Liberar buscas rápidas
                'finder' => false,

                // Página padrão
                'default' => 'index',

                // Permissões de acesso
                'permissoes' => array(),

                // Permissões de acesso liberadas
                'permissoes.liberadas' => array()
            );

            // mescla com as configurações padrões
            $configuracoes = array_merge($padrao, $configuracoes);

	    // verifica se o usuário tem permissão no finder
	    if($configuracoes['finder'] && $veriFinder)
		$configuracoes['finder'] = jAccess("finder", array('retorno' => 'bool', 'programa' => $programa)) ? $configuracoes['finder'] : false;

            if($json)
                echo json_encode($configuracoes);
            else
                return $configuracoes;
        }
    }

    public function get_list() {

	// Carrega os dados dos grupos
	$grupo = $_SESSION['eDesktop.usuario.grupo'];

        // inicia uma array
	$programas = array();
	$json = array();

	if($grupo['id'] != 1)
	{
	    // carrega as permissões
	    $permissoes = $_SESSION['eDesktop.usuario.grupo.permissoes'];

	    // loop entre as permissões
	    foreach($permissoes as $permissao)
	    {
		// separa as string
		list($programa, $pagina) = explode('.', $permissao, 2);

		// adiciona a programa
		$programas[$programa] = $programa;
	    }

	    // loop entre os programas
	    foreach($programas as $programa) {
		$a = array('programa' => $programa);
		$b = $this->get_config($programa);

		$json[] = array_merge($a, $b);
	    }
	}
	else
	{
	    jimport('joomla.filesystem.folder');
	    $programas = JFolder::folders(EDESKTOP_PATH_PROGRAMAS);
	    
	    // loop entre os programas
	    foreach($programas as $programa) {
		$a = array('programa' => $programa);
		$b = $this->get_config($programa);

		$json[] = array_merge($a, $b);
	    }
    	}

	// exibe o json
	echo json_encode($json);
	
    }


    public function conteudo() {

        $script = '';

        if(!$this->funcao) {
            // abre as configurações do programa
            $this->config = $this->get_config($this->programa);

            if($this->pagina == 'index') {
                $this->pagina = $this->config['default'];
                JRequest::setvar('pagina', $this->config['default']);
            }

            // carrega os menus laterais
            jimport('edesktop.menu.lateral');

            // verifica se existe o arquivo menus.php
            if(file_exists($this->pasta .DS. 'menus.php'))
                require_once($this->pasta .DS. 'menus.php');


			// inicia a class
			$dados = new stdClass();
			
			// carrega a messagem de retorno
			$dados->msg = JRequest::getvar('msg', '');
			$dados->msgTipo = JRequest::getvar('msg_tipo', 'error');

            // inicia as variaveis de sessão do dialog/pagina
            $script = "<script type=\"text/javascript\">
                            $(function(){
                                    var processID = '{$this->processID}';
                                    var \$dialog = $('#d' +processID);
                                    var \$main = \$dialog.parent();

                                    var url_js = '{$this->url_programa}/js';
                                    var url_base = '{$this->url_base}';
                                    var url_programa = '{$this->url_programa}';
                                    
                                    var msg = '{$dados->msg}';
                                 
									if(msg != '')
										eDesktop.dialog.aviso(msg, '{$dados->msgTipo}', \$('.corpo', \$main));

                                    var pagina = '{$this->pagina}';
                                    var programa = '{$this->programa}';

                                    var formURL = function(pagina, programa){
                                            programa = (programa == undefined) ? '{$this->programa}' : programa;
                                            return '?{$this->token}=1&template={$this->template}&class=programa&programa=' +programa+ '&method=conteudo&pagina=' + pagina;
                                    };
                                    
                                    // botões
                                    $('.button, .acoes .submit').button();
                    ";


            // verifica se existe o arquivo js
            $js_file = $this->pasta_paginas .DS. $this->pagina.'.js';
            if(file_exists($js_file) && filesize ($js_file)) {
                $handle = fopen($js_file, "r");
                $js_file = fread ($handle, filesize ($js_file));
                fclose ($handle);
                $script .= "// js_file\n\n". $js_file. "\n\n";
            }

            $script .= "});\n</script>\n\n";

        }

        // verifica a permissão do usuário
        jAccess($this->pagina);

        // envia o formURL para o smarty
        $this->smarty->assign('formURL', $this->formURL(''));

        // envia o processID para o smarty
        $this->smarty->assign('processID', $this->processID);

        // abre a página
        $pagina = $this->pasta_paginas .DS. $this->pagina;
        
		// carrega o php
        if(file_exists($pagina. '.php'))
        {
            require_once($pagina .'.php');

            if(!$this->funcao)
            {
				echo $script;

				if(file_exists($pagina .'.html'))
					echo $this->smarty->fetch($pagina. '.html');
			}
        }
        else
        {
            if($this->funcao)
                echo "{ 'msg' : 'Arquivo não encontrado! \"{$this->pagina}.html\"', 'retorno' : false, 'tipo' : 'error' }";
			else
				echo "Arquivo não encontrado!<br><br>$pagina.html<br><br><br><br><a href=\"javascript:void(0);\" class=\"link\" rel=\"{}\">Voltar</a>";        
        }
    }

    public function formURL($pagina, $programa = '') {
        $programa = ($programa == '') ? $this->programa : $programa;
        $url = "?{$this->token}=1&template={$this->template}&class=programa&programa={$programa}&funcao=1&method=conteudo&pagina={$pagina}";
        return $url;
    }

}



?>
