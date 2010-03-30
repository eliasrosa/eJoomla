<?
$configuracoes = array
(
    'titulo'  => 'Usuários',
    'finder'  => true,
    'default' => 'listagem',
    'paginas' => array(
		'listagem' => array(
			'menu' => true,
			'label' => 'Listar todos',
			'target' => 'conteudo',
			'descricao' => 'Lista de usuários cadastrados no sistema' 
		),
		'cadastro' => array(
			'menu' => true,
			'label' => 'Cadastrar novo',
			'target' => 'conteudo',
			'descricao' => 'Cadastre novo usuário para acessar o sistema'
		)	
	)
);
?>
