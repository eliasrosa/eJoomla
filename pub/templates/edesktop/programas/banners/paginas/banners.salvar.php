<?
// recebe todo os dados
$d1  = JRequest::getvar('d1', array(), 'array');
$id  = isset($d1['id']) ? $d1['id'] : 0;
$msg = '';


if(empty($d1['nome']))
    $msg .= '- O campo \'Nome\' é obrigatório!<br>';

if(!(int) $d1['largura'])
    $msg .= '- O campo \'Largura\' é obrigatório!<br>';

if(!(int) $d1['altura'])
    $msg .= '- O campo \'Altura\' é obrigatório!<br>';

if(empty($d1['allow']))
    $msg .= '- O campo \'Arquivos permitidos\' é obrigatório!<br>';

if(empty($d1['modelo']))
    $msg .= '- O campo \'Modelo\' é obrigatório!<br>';

if(!empty($msg))
    jexit(json_encode(array('tipo' => 'error', 'msg' => 'Preencha corretamente o(s) seguinte(s) campo(s):<br><br>'.$msg)));

// abre a biblioteca de dados
jimport('edesktop.programas.banners');

// carrega a lib
$a = new edBanners();
$r = $a->salva_banner($id, $d1);

// imprime o retorno
jexit(json_encode($r));	
?>