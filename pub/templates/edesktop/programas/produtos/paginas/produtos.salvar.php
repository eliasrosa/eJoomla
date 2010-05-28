<?
//


// recebe todo os dados
$msg = '';
$produto = $_POST['produto'];
$id = isset($_POST['produto']['id']) ? $_POST['produto']['id'] : 0;


if(empty($produto['nome']))
    $msg .= '- O campo \'Nome\' é obrigatório!<br>';


if(!empty($msg))
    jexit(json_encode(array('tipo' => 'error', 'msg' => 'Preencha corretamente o(s) seguinte(s) campo(s):<br><br>'.$msg)));



// valor
$produto['valor'] = str_replace(',','.', $produto['valor']);


jimport( 'joomla.filter.output' );
if(JFilterOutput::stringURLSafe($produto['alias']) != '')
	$produto['alias'] = JFilterOutput::stringURLSafe($produto['alias']);



/* TABELA PRODUTOS
 * ******************************/

// abre a tabela com os novo dados
jimport('edesktop.programas.produtos.produtos');
$produto = new edesktop_produtos_produtos($produto);

// verifica se o registro já existe
if($id)
{
    // atualiza os dados do registro
    $produto->db->update();

    // carrega as vars de retorno
    $retorno = 'updateOk';
    $msg = 'Dados do produto foram atualizados com sucesso!';
}
else
{
    // cadastra o novo registro
    $produto->db->insert();

    // carrega as vars de retorno
    $retorno = 'insertOk';
    $msg = 'Produto cadastrado com sucesso!';	
}

// imprime o retorno
jexit(json_encode(array('msg' => $msg, 'retorno' => $retorno, 'produto' => $produto->db->get_dados())));
	
	
?>