<?php

// evitar acesso direto
defined('_JEXEC') or die('Acesso restrito');

// carrega o raquivo comum
require_once(JPATH_ROOT.DS.'media'.DS.'com_ecomp'.DS.'comum.php');

// carrega o util
require_once(ECOMP_PATH_CLASS.DS.'ebasic.util.php');

// carrega o jcrud
jimport('edesktop.jcrud');

// carrega o helper
require_once(ECOMP_PATH_CLASS.DS.'ebasic.helper.php');

// carrega o smarty
jimport('edesktop.smarty.class');

// Solicitar o controlador base
require_once(JPATH_COMPONENT.DS.'controlador.php');

// Criar o controlador
$controller = new ecompController();

// Obter a solicitação da tarefas
$controller->execute(JRequest::getVar('task', null));

// O controlador redireciona conforme a tarefa
$controller->redirect();
?>

