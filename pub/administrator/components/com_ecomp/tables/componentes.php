<?php
// evitar acesso direto
defined('_JEXEC') or die('Acesso restrito');

class TABLEcomponentes extends JTable
{
    var $id = null;
    var $idMenuAdmin = null;
    var $nome = null;
    var $alias = null;

    var $published = null;
    var $trashed = null;
    var $ordering = null;

    function __construct(&$db) {
        parent::__construct('#__ecomp_componentes', 'id', $db);
    }
}
?>
