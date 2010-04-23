<?php
    header("X-UA-Compatible: IE=EmulateIE7");
    $url = "{$this->baseurl}/templates/{$this->template}";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<jdoc:include type="head" />
	<link type="text/css" href="<?= $url ?>/styles/style.css" rel="Stylesheet" />
	<link type="text/css" href="<?= $url ?>/styles/<?= $this->params->get('tpl_style'); ?>/style.css" rel="Stylesheet" />
    </head>
    <body>
	<div id="corpo">
	    <div id="col1">
		<img src="<?= $url ?>/img/logo.png" />
		<h2>Aguarde, em breve uma novidade para você!</h2>
	    </div>
	    <div id="col2">
		<img src="<?= $url ?>/styles/<?= $this->params->get('tpl_style'); ?>/fale-conosco.png" />
		<p>Para entrar em contato conosco, é muito simples, basta nos enviar um e-mail pelo formulário abaixo e em breve entraremos em contato com você.</p>
		[eFormMail "<?= $this->params->get('tpl_idForm'); ?>"]
	    </div>
	</div>
    </body>
</html>
