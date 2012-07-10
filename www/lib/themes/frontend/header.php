<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
?>
<!DOCTYPE html>
<html lang="<?php print get("webLang"); ?>">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title><?php print $this->getTitle(); ?></title>
		
		<link href="<?php print path("www/lib/css/frameworks/bootstrap/bootstrap.min.css", TRUE); ?>" rel="stylesheet">
		<link href="<?php print $this->themePath; ?>/css/style.css" rel="stylesheet">
		<?php print $this->getCSS(); ?>
	</head>

	<body>
	   	<div class="content">
          	<div class="row bg-white" title="header">
          		<div class="span3 logo">
            		<h1>Gidi</hi>
          		</div>

          		<div class="span9 top-menu">
          			<ul>
          				<li>
							<a href="<?php print path("pages") ;?>" title="<?php print __(_("Welcome"));?>">
								<?php print __(_("Bienvenida"));?>
							</a>
						</li>
          				
          				<li>
							<a href="<?php print path("pages") . _sh . slug(__(_("Nosotros")));?>" title="<?php print __(_("Us"));?>">
								<?php print __(_("Nosotros"));?>
							</a>
						</li>
          				
          				<li>
							<a href="<?php print path("pages") . _sh . slug(__(_("Procedimiento de diagnostico")));?>" title="<?php print __(_("Diagnostic fail"));?>">
								<?php print __(_("Procedimiento de diagnostico"));?>
							</a>
						</li>
						
						<li>
							<a href="<?php print path("pages") . _sh . slug(__(_("Ubicacion y Contacto")));?>" title="<?php print __(_("Location and contact"));?>">
								<?php print __(_("Ubicacion y Contacto"));?>
							</a>
						</li>
          			</ul>
          		</div>
        	</div>
