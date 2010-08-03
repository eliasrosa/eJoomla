<?
$configuracoes = array (
	// Titulo do programa
	'titulo' => 'Mailing',

	// Liberar buscas rápidas
	'finder' => false,

	// Página padrão
	'default' => 'enviarUm.form',

	// Permissões de acesso
	'permissoes' => array(
		'enviarUm.form' => 'Enviar e-emails para um único contato',
		'enviarLista.form' => 'Enviar e-emails para uma lista'
	),

	// Permissões de acesso liberadas
	'permissoes.liberadas' => array(
		'enviarUm.send', 'enviarLista.send'
	)
);
?>
