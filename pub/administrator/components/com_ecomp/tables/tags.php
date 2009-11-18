<?php
// evitar acesso direto
defined('_JEXEC') or die('Acesso restrito');

class TABLEtags extends JTable
{
    var $id = null;
    var $idpai = null;
    var $idcomponente = null;
    var $nome = null;
    var $alias = null;
    var $ordering = null;
    var $trashed = null;
    var $published = null;

    function __construct(&$db) {
        parent::__construct('#__ecomp_tags', 'id', $db);
    }


}
?>
