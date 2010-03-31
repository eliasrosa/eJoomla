<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>eDesktop - v1.0 Beta</title>
		<link type="text/css" href="<?= EDESKTOP_URL_CSS ?>/redmond/jquery-ui-1.8rc2.custom.css" rel="stylesheet" />	
		<link type="text/css" href="<?= EDESKTOP_URL_CSS ?>/init.css" rel="stylesheet" />	
		<script type="text/javascript" src="<?= EDESKTOP_URL_JS ?>/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="<?= EDESKTOP_URL_JS ?>/jquery-ui-1.8rc2.custom.min.js"></script>
		<script type="text/javascript" src="<?= EDESKTOP_URL_JS ?>/eDesktop.login.js"></script>
	</head>
	<body>
		<div id="login">
			<p>Entre com seus dados de usuário:</p>
			<form method="post">
				<table>
					<tr>
						<td>Usuário:</td>
						<td><input type="text" name="username" class="text ui-widget-content ui-corner-all" /></td>
					</tr><tr>
						<td><label for="password">Senha: </label></td>
						<td><input type="password" name="passwd" value="" class="text ui-widget-content ui-corner-all" /></td>
					</tr>
				</table>
				<input type="submit" value="Entrar" />
				<? if($erro) { ?><p class="aviso">Usuário ou senha inválida, tente novamente!</p><? } ?>
				<?php echo JHTML::_( 'form.token' ); ?>
			</form>
		</div>
	</body>
</html>
