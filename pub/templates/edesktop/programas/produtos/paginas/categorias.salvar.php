<?
// recebe todo os dados
$msg = '';
$dados = $_POST['categoria'];
$id = isset($_POST['categoria']['id']) ? $_POST['categoria']['id'] : 0;


if(empty($dados['nome']))
    $msg .= '- O campo \'Nome\' é obrigatório!<br>';


if(!empty($msg))
    jexit(json_encode(array('tipo' => 'error', 'msg' => 'Preencha corretamente o(s) seguinte(s) campo(s):<br><br>'.$msg)));


// abre a tabela com os novo dados
jimport('edesktop.programas.produtos.categorias');
$cat = new edesktop_produtos_categorias($dados);

// verifica se o registro já existe
if($id)
{
	// verifica se o usuario logado tem permissão
    jAccess('categorias.editar');
    	
    // atualiza os dados do registro
    $cat->db->update();

    // carrega as vars de retorno
    $retorno = 'updateOk';
    $msg = 'A categoria do produto foi atualizado com sucesso!';
}
else
{
	// verifica se o usuario logado tem permissão
    jAccess('categorias.adicionar');	
	
    // cadastra o novo registro
    $cat->db->insert();

    // carrega as vars de retorno
    $retorno = 'insertOk';
    $msg = 'A categoria do produto foi cadastrado com sucesso!';	
}

// imprime o retorno
jexit(json_encode(array('msg' => $msg, 'retorno' => $retorno, 'id' => $cat->db->id)));
	
	
?>