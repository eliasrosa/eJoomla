<?php require_once('inc/comum.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<style type="text/css" media="all">@import "<?php echo $base ?>/css/style.css";</style>
	<script type="text/javascript" src="<?php echo $base ?>/js/comum.js"></script>
</head>

<body>
	<div id="geral">
		<div id="topo">
			<div id="menu">
				<?php

				require_once('inc/manager.menu.php');

				$menu = new manager_menu();
				$menu->exibir();

				?>
				<br class="clearfix" />
			</div>
		</div>
	</div>
</body>

</html>
