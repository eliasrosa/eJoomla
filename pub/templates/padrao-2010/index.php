<?php

	header("X-UA-Compatible: IE=EmulateIE7");
	$url = "{$this->baseurl}/templates/{$this->template}";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<jdoc:include type="head" />
		
   		<link type="text/css" href="<?= $url ?>/css/style.css" rel="Stylesheet" />
        <script type="text/javascript" src="<?= $url ?>/js/comum.js"></script>
		
		<!--[if lte IE 7]>
			<link type="text/css" href="<?= $url ?>/css/style-ie.css" rel="Stylesheet" />
		<![endif]-->
    
    </head>
    <body>
    
		<!--
		<jdoc:include type="modules" name="search" style="limpo" />
		<jdoc:include type="component" style="limpo" />
		-->
    	
	</body>
</html>
