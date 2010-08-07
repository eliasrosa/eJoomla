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

// opções
$opcoes = JRequest::getVar('opcoes', array());
$opcoes_itens = JRequest::getVar('opcoes_itens', array());
$produto['opcoes'] = array();
$i = 0;
foreach($opcoes as $k=>$v)
{
	$idk = key($v);
		
	$produto['opcoes'][$i]['nome'] = trim($v[$idk]);
	$produto['opcoes'][$i]['itens'] = array();
				
	foreach($opcoes_itens[$idk] as $item)
	{
		if(trim($item) != '')
			$produto['opcoes'][$i]['itens'][] = trim($item);
	}

	if(!count($produto['opcoes'][$i]['itens']))
		unset($produto['opcoes'][$i]);
	else	
		$i++;
}

//print_r($produto['opcoes']);

$produto['opcoes'] = json_encode($produto['opcoes']);


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
	// verifica se o usuario logado tem permissão
    jAccess('produtos.editar');
	
    // atualiza os dados do registro
    $produto->db->update();
    
    // pega as categorias do produto
    $categorias = JRequest::getvar('categorias', array(), 'array');
    
    // salva categotorias relacionadas
    $produto->salva_categorias($id, $categorias);

    // carrega as vars de retorno
    $retorno = 'updateOk';
    $msg = 'Dados do produto foram atualizados com sucesso!';
}
else
{
	// verifica se o usuario logado tem permissão
    jAccess('produtos.adicionar');
		
    // cadastra o novo registro
    $produto->db->insert();

    // carrega as vars de retorno
    $retorno = 'insertOk';
    $msg = 'Produto cadastrado com sucesso!';	
}

// imprime o retorno
jexit(json_encode(array('msg' => $msg, 'retorno' => $retorno, 'produto' => $produto->db->get_dados())));
	
	
?>