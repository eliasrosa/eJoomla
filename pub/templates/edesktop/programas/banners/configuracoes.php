<?
$configuracoes = array (
        // Titulo do programa
        'titulo' => 'Banners',

        // Liberar buscas rápidas
        'finder' => false,

        // Página padrão
        'default' => 'banners.lista',

        // Permissões de acesso
        'permissoes' => array(
        
			// banners
			'banners.lista' => 'Visualizar lista de banners',
			'banners.form' => 'Visualizar dados dos banners',
			'banners.editar' => 'Editar dados dos banners',
			'banners.adicionar' => 'Adicionar novos banners',
			'banners.remover' => 'Remover banners',
			'banners.admin' => 'Adiministrar uploads'

        
        ),

        // Permissões de acesso liberadas
        'permissoes.liberadas' => array(
			'banners.salvar'
        )
);
?>
