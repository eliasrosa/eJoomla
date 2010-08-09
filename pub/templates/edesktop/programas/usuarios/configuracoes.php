<?
$configuracoes = array (
        // Titulo do programa
        'titulo' => 'Usuários',

        // Liberar buscas rápidas
        'finder' => false,

        // Página padrão
        'default' => 'usuarios.lista',

        // Permissões de acesso
        'permissoes' => array(

		// Usuários
                'usuarios.lista' => 'Visualizar lista de usuários',
                'usuarios.form' => 'Visualizar dados dos usuários',
                'usuarios.editar' => 'Editar dados dos usuários',
                'usuarios.adicionar' => 'Adicionar novos usuários',
                'usuarios.remover' => 'Remover usuários',
		'usuarios.bloquearUsuarios' => 'Bloquear usuários',
		'usuarios.alterarUsuarioSenha' => 'Alterar usuário e senha',
		'usuarios.alterarGrupoJoomla' => 'Alterar grupo Joomla!',


		// Grupos de usuários
                'grupos.lista' => 'Visualizar lista de grupos',
                'grupos.form' => 'Visualizar dados dos grupos',
                'grupos.editar' => 'Editar dados dos grupos',
                'grupos.adicionar' => 'Adicionar novos grupos',
                'grupos.remover' => 'Remover grupos',
                'grupos.alterarStatus' => 'Bloquear grupos',
		'grupos.alterarPermissoesAcesso' => 'Alterar permissões de acesso'
        ),

        // Permissões de acesso liberadas
        'permissoes.liberadas' => array(
                'usuarios.salvar',
                'grupos.salvar'
        )
);
?>
