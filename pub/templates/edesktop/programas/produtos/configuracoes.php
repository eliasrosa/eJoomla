<?
$configuracoes = array (
        // Titulo do programa
        'titulo' => 'Produtos',

        // Liberar buscas rápidas
        'finder' => false,

        // Página padrão
        'default' => 'produtos.lista',

        // Permissões de acesso
        'permissoes' => array(

			// produtos
			'produtos.lista' => 'Visualizar lista de produtos',
			'produtos.form' => 'Visualizar dados dos produtos',
			'produtos.editar' => 'Editar dados dos produtos',
			'produtos.adicionar' => 'Adicionar novos produtos',
			'produtos.remover' => 'Remover produtos',


			// textos
			'textos.lista' => 'Visualizar lista de textos',
			'textos.form' => 'Visualizar dados dos textos',
			'textos.editar' => 'Editar dados dos textos',
			'textos.adicionar' => 'Adicionar novos textos',
			'textos.remover' => 'Remover textos',

        ),

        // Permissões de acesso liberadas
        'permissoes.liberadas' => array(
            'produtos.salvar',
            'textos.salvar'
        )
);
?>
