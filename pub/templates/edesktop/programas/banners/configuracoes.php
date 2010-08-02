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
			
			// slides
			'slides.lista' => 'Visualizar lista de slides',
			'slides.form' => 'Visualizar dados dos slides',
			'slides.editar' => 'Editar dados dos slides',
			'slides.adicionar' => 'Adicionar novos slides',
			'slides.preview' => 'Visualizar arquivos de slides',
			'slides.remover' => 'Remover slides'        
        ),

        // Permissões de acesso liberadas
        'permissoes.liberadas' => array(
			'banners.salvar', 'slides.salvar'
        )
);
?>
