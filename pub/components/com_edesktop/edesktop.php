<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Solicitar o controlador base
require_once( JPATH_COMPONENT.DS.'controlador.php' );

// import JCRUD
jimport( 'edesktop.jcrud');
 
// Criar o controlador
$nomeclasse  = 'edesktopCONTROLLER';
$controlador = new $nomeclasse;
 
// Obter a solicitação da tarefa
$controlador->execute( JRequest::getVar( 'task' ) );
 
// O controlador redireciona conforme a tarefa
$controlador->redirect();

?>