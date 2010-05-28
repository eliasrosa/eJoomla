<?
//


// recebe todo os dados
$msg = '';
$dados = $_POST['texto'];
$id = isset($_POST['texto']['id']) ? $_POST['texto']['id'] : 0;


if(empty($dados['titulo']))
    $msg .= '- O campo \'Título\' é obrigatório!<br>';

if(empty($dados['html']))
    $msg .= '- O texto não pode estar vazio!<br>';

if(!$dados['idproduto'])
    $msg .= '- ID do produto não foi encontrado!<br>';


if(!empty($msg))
    jexit(json_encode(array('tipo' => 'error', 'msg' => 'Preencha corretamente o(s) seguinte(s) campo(s):<br><br>'.$msg)));



// adiciona os <br>
$dados['html'] = str_replace("\n", '<br>', $dados['html']);


// abre a tabela com os novo dados
jimport('edesktop.programas.produtos.textos');
$texto = new edesktop_produtos_textos($dados);

// verifica se o registro já existe
if($id)
{
    // atualiza os dados do registro
    $texto->db->update();

    // carrega as vars de retorno
    $retorno = 'updateOk';
    $msg = 'O texto do produto foi atualizado com sucesso!';
}
else
{
    // cadastra o novo registro
    $texto->db->insert();

    // carrega as vars de retorno
    $retorno = 'insertOk';
    $msg = 'O texto do produto foi cadastrado com sucesso!';	
}

// imprime o retorno
jexit(json_encode(array('msg' => $msg, 'retorno' => $retorno, 'produto' => $texto->db->id)));
	
	
?>