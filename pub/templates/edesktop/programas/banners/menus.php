<?
	$menu_principal = new menu_lateral('Menu principal');
	$menu_principal->add('Lista de banners', 'banners.lista');	
	$menu_principal->add('Cadastro', 'banners.form');
	
	$idbanner = JRequest::getvar('idbanner', 0);

	$menu_slides = new menu_lateral('Administração de slides', true);
	$menu_slides->add('Listar todos', array('pagina' => 'slides.lista', 'query' => "idbanner={$idbanner}"));	
	$menu_slides->add('Cadastro', array( 'pagina' => 'slides.form', 'query' => "idbanner={$idbanner}"));
?>