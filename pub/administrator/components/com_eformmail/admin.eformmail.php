<?php
// evitar acesso direto
defined('_JEXEC') or die('Acesso restrito');

// Carrega a biblioteca
require_once(JPATH_COMPONENT.DS.'ebasic'.DS.'ebasic.php' );

// Inicia o objeto eBasic
$eBasic =& new eBasic();

// Inicia o componente
$eBasic->componentStart();

?>