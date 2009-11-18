<?php
// evitar acesso direto
defined('_JEXEC') or die('Acesso restrito');

class TABLEimagens extends JTable
{
    var $id = null;
    var $idcadastro = null;
    var $idcomponente = null;
    var $file = null;
    var $legenda = null;
    var $descricao = null;
    var $resumo = null;
    var $grupo = null;
    var $ordering = null;
    var $trashed = null;
    var $published = null;

    function __construct(&$db) {
        parent::__construct('#__ecomp_cadastros_imagens', 'id', $db);
    }
}
?>
