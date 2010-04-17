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

    function login() {
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

            if(!JError::isError($error)) {
                $mainframe->redirect( $return );
            }
            else {
                $mainframe->redirect( $return. '&erro=1' );
            }
        }

        require_once(EDESKTOP_PATH .DS. "login.php");
        exit();

    }


    function logout() {
        global $mainframe;

        // Carrega a ação de logout
        $error = $mainframe->logout();

        if(!JError::isError($error)) {
            $return = '?template=edesktop';
            $mainframe->redirect( $return );
        }
    }


    function abri_conteudo() {

        // Recebe a method e class
        $method = JRequest::getvar('method', false);
        $class = JRequest::getvar('class', false);

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

}

?>
