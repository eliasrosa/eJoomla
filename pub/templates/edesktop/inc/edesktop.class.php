<?php

class eDesktop {
    function __construct($joomla) {
        // Carrega a saída - UTF-8
        @header('Content-Type: text/html; charset=utf-8');

        // Inicia a sessão
        @session_start();

        // Constantes path do eDesktop
        define('EDESKTOP_PATH', JPATH_THEMES .DS. 'edesktop');
        define('EDESKTOP_PATH_INC', EDESKTOP_PATH .DS. 'inc');
        define('EDESKTOP_PATH_PROGRAMAS', EDESKTOP_PATH .DS. 'programas');
        define('EDESKTOP_PATH_CACHE', JPATH_ROOT .DS. 'cache' .DS. 'edesktop');
        define('EDESKTOP_PATH_SMARTY_CACHE', EDESKTOP_PATH_CACHE .DS. 'cache');
        define('EDESKTOP_PATH_SMARTY_COPILE', EDESKTOP_PATH_CACHE .DS. 'copile');

        // Constantes url do eDesktop
        define('EDESKTOP_URL', "{$joomla->baseurl}/templates/{$joomla->template}");
        define('EDESKTOP_URL_JS', EDESKTOP_URL. "/js");
        define('EDESKTOP_URL_CSS', EDESKTOP_URL. "/css");
        define('EDESKTOP_URL_IMG', EDESKTOP_URL. "/img");

        // Constantes padrões do eDesktop
        define('EDESKTOP_TOKEN', JUtility::getToken());
        define('EDESKTOP_TEMPLATE', $joomla->template);

        // Cria estrutura de pastas importantes
        if(!is_dir(EDESKTOP_PATH_CACHE)) @mkdir(EDESKTOP_PATH_CACHE);
        if(!is_dir(EDESKTOP_PATH_SMARTY_CACHE)) @mkdir(EDESKTOP_PATH_SMARTY_CACHE);
        if(!is_dir(EDESKTOP_PATH_SMARTY_COPILE)) @mkdir(EDESKTOP_PATH_SMARTY_COPILE);

        // Carrega a class JCRUD
        jimport('edesktop.jcrud');

        // Carrega a funcão jAccess
        require_once(EDESKTOP_PATH_INC .DS. 'jaccess.function.php');

        // Carrega dados do usuário
        $this->user =& JFactory::getUser();

        // Verifica se usuário é visitante
        if($this->user->guest)
            $this->login();

        // Verifica se o usuário está se desconectando
        if(JRequest::getvar('logout', false))
            $this->logout();

        // Se o usuário passar pelos teste acima, abre o conteudo
        $this->abri_conteudo();
    }

    private function login() {
        global $mainframe;
        $erro  = JRequest::getvar('erro', false);
        $return	= 'index.php?template=edesktop';
        $credentials = array();
        $credentials['username'] = JRequest::getVar('username', '', 'method', 'username');
        $credentials['password'] = JRequest::getString('passwd', '', 'post', JREQUEST_ALLOWRAW);

        if(!empty($credentials['username']) || !empty($credentials['password']) ) {

            // Checa o token
            JRequest::checkToken('request') or jexit( 'eDesktop: Invalid Token' );
	    
	    // Carrega a ação de logout
            $error = $mainframe->login($credentials);
    
            if(!JError::isError($error) && $this->user->block != 1) {

		// Carrega os dados do usuário
		$u = new JCRUD("jos_users", array('id' => $this->user->id));

		// Carrega os dados do grupo
		$g = new JCRUD("jos_edesktop_usuarios_grupos", array('id' => $u->id_grupo));

		// verifica se o grupo do usuário esta ativo
		if($g->status == 1){
		    // redireciona ao usuario
		    $mainframe->redirect( $return );
		}
		else{
		    // desconecta sem redirecionar
		    $this->logout(false);

                    // redireciona ao usuario
	            $mainframe->redirect( $return. '&erro=2' );
		}
            }
            else {
                // redireciona ao usuario
                $mainframe->redirect( $return. '&erro=1' );
            }
        }

        require_once(EDESKTOP_PATH .DS. "login.php");

        jexit();
    }

    private function logout($redirect = true) {
        global $mainframe;

        // Carrega a ação de logout
        $error = $mainframe->logout();

        if(!JError::isError($error) && $redirect) {
            $return = '?template=edesktop';
            $mainframe->redirect( $return );
        }
    }

    private function abri_conteudo() {
        // Recebe a method e class
        $method = JRequest::getvar('method', false);
        $class = JRequest::getvar('class', false);

	// Carrega as permissões do usuários
	$this->permissoes();
	
        // Caso exista uma class e função
        if($class && $method) {

            // Importa a class solicitada
            jimport("edesktop.{$class}");

            // Verifica se existe o method
            if(method_exists($class, $method)) {
                $class = new $class();
                $class->$method();
            }
            else
                echo "Method '{$method}' não econtrado na class '{$class}'!";
        }
        else {
            require_once(EDESKTOP_PATH .DS. "home.php");
        }
    }

    private function permissoes() {
        // Carrega os dados do usuário
        $u = new JCRUD("jos_users", array('id' => $this->user->id));

        // Carrega os dados do grupo
        $g = new JCRUD("jos_edesktop_usuarios_grupos", array('id' => $u->id_grupo));

        // Grava na sessão os dados do usuário
        $_SESSION['eDesktop.usuario'] = $u->get_dados();

        // Grava na sessão os dados do grupo do usuário
        $_SESSION['eDesktop.usuario.grupo'] = $g->get_dados();

        // Separa as permissões em um array e grava na sessão
        $_SESSION['eDesktop.usuario.grupo.permissoes'] = ($g->permissoes != '') ? explode("\n", $g->permissoes) : array();
    }
}

?>
