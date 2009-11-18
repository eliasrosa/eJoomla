<?php
// evitar acesso direto
defined('_JEXEC') or die('Acesso restrito');

class TABLEeformmail extends JTable
{
    var $id = null;
    var $name = null;
    var $subject = null;
    var $to = null;
    var $from = null;
    var $replyto = null;
    var $cc = null;
    var $co = null;
    var $message = null;
    var $form = null;
    var $charset = null;
    var $type = null;
    var $published = null;
    var $trashed = null;

    function __construct(&$db) {
        parent::__construct('#__eformmail_formularios', 'id', $db);
    }


}
?>