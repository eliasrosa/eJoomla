<?php
// evitar acesso direto
defined('_JEXEC') or die('Acesso restrito');

class TABLEcampos extends JTable
{
    var $id = null;
    var $idcomponente = null;
    var $nome = null;
    var $label = null;
    var $tipo = null;
    var $ordering = null;
    var $trashed = null;
    var $published = null;

    function __construct(&$db) {
        parent::__construct('#__ecomp_campos', 'id', $db);
    }


}
?>
