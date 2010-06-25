<?
// recebe todo os dados

jimport('joomla.filesystem.file');
$file = JRequest::getVar('file_upload', null, 'files', 'array');
$file_name = strtolower(JFile::makeSafe($file['name']));
$file_ext = JFile::getExt($file_name);
$src = $file['tmp_name'];

$msg = '';
$dados = JRequest::getvar('imagem', array(), 'array');
$id = isset($dados['id']) ? $dados['id'] : 0;

if(empty($dados['nome']))
    $msg .= '- O campo \'Nome\' é obrigatório!<br>';

if(!$dados['idproduto'])
    $msg .= '- ID do produto não foi encontrado!<br>';

if($src && $file_ext != 'jpg')
    $msg .= '- Imagem inválida, somente arquivos JPG!<br>';

if(!empty($msg))
    jexit(json_encode(array('tipo' => 'error', 'msg' => 'Preencha corretamente o(s) seguinte(s) campo(s):<br><br>'.$msg)));

// abre a tabela com os novo dados
jimport('edesktop.programas.produtos.imagens');
$img = new edesktop_produtos_imagens($dados);

// verifica se o registro já existe
if($id)
{
	// verifica se o usuario logado tem permissão
    jAccess('imagens.editar');	
	
    // atualiza os dados do registro
    $img->db->update();
    
    // remove as outras imagens e destaque
    $img->db->query("UPDATE @tabela@ SET destaque = '0' WHERE id != '{$img->db->id}' AND idproduto = '{$img->db->idproduto}' ");

    // carrega as vars de retorno
    $retorno = 'updateOk';
    $msg = 'A imagem do produto foi atualizada com sucesso!';
}
else
{
	// verifica se o usuario logado tem permissão
    jAccess('imagens.adicionar');	
	
    // cadastra o novo registro
    $img->db->insert();

    // remove as outras imagens e destaque
    $img->db->query("UPDATE @tabela@ SET destaque = '0' WHERE id != '{$img->db->id}' AND idproduto = '{$img->db->idproduto}' ");

    // carrega as vars de retorno
    $retorno = 'insertOk';
    $msg = 'A imagem do produto foi cadastrada com sucesso!';	
}


// upload
$dest = JPATH_BASE . "{$img->pasta}/{$img->db->id}.{$file_ext}";

if($src)
	if(!JFile::upload($src, $dest))
		$msg = "Dados atualizados, imagem não foi enviada!";

// imprime o retorno
jexit(json_encode(array('msg' => $msg, 'retorno' => $retorno, 'id' => $img->db->id, 'idproduto' => $img->db->idproduto)));
	
	
?>