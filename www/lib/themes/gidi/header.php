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
		<script tyle="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<link href="<?php print path("www/lib/css/ui-lightness/jquery-ui-1.8.17.custom.css", TRUE); ?>" rel="stylesheet">
		<link href="<?php print $this->themePath; ?>/css/style.css" rel="stylesheet">
		<?php print $this->getCSS(); ?>

		<script type="text/javascript">
			var PATH = "<?php print path(); ?>";
			
			var URL  = "<?php print get('webURL'); ?>";
		</script>

		<link rel="stylesheet" href="<?php echo path("www/lib/scripts/js/nivo/themes/default/default.css"); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo path("www/lib/scripts/js/nivo/themes/light/light.css"); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo path("www/lib/scripts/js/nivo/themes/dark/dark.css"); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo path("www/lib/scripts/js/nivo/themes/bar/bar.css"); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo path("www/lib/scripts/js/nivo/nivo-slider.css"); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo path("www/lib/scripts/js/nivo/style.css"); ?>" type="text/css" media="screen" />
	</head>

	<body>
  	<div class="content">
     	<div class="row bg-white" title="header">
        <div class="span3 logo">
       		<a href="<?php print path("cpanel"); ?>"><img src="<?php print path("www/lib/themes/gidi/images/logo.png", TRUE); ?>" alt="Gidi" /></a>
        </div>

		<div class="span10 top-menu">			
			<ul class="nav">
				<li class="dropdown" data-dropdown="dropdown" >
					<a href="#" class="dropdown-toggle" title="Páginas">Páginas</a>
					<ul class="dropdown-menu">
						<li><a href="<?php print path("pages/cpanel/results/"); ?>">Todas</a></li>
						<li><a href="<?php print path("pages/cpanel/add/"); ?>">Agregar</a></li>
						<li><a href="<?php print path("pages/cpanel/results/trash/"); ?>">Papelera</a></li>
					</ul>
				</li>
			</ul>
			
			<ul class="nav">
				<li class="dropdown" data-dropdown="dropdown2" >
					<a href="#" class="dropdown-toggle" title="Centros">Centros</a>
					<ul class="dropdown-menu option2">
						<li><a href="<?php print path("centers/cpanel/results/"); ?>">Todos</a></li>
						<li><a href="<?php print path("centers/cpanel/add/"); ?>">Agregar</a></li>
						<li><a href="<?php print path("centers/cpanel/results/trash/"); ?>">Papelera</a></li>
					</ul>
				</li>
			</ul>
			
			<ul class="nav">
				<li class="dropdown" data-dropdown="dropdown" >
					<a href="#" class="dropdown-toggle" title="Usuarios">Usuarios</a>
					<ul class="dropdown-menu option6">
						<li><a href="<?php print path("users/cpanel/results/"); ?>">Todos</a></li>
						<li><a href="<?php print path("users/cpanel/add/"); ?>">Agregar</a></li>
						<li><a href="<?php print path("users/cpanel/results/trash/"); ?>">Papelera</a></li>
					</ul>
				</li>
			</ul>
			
			<ul class="nav"><li><a href="<?php print path("patients"); ?>" title="Reportes">Pacientes</a></li></ul>
			<ul class="nav"><li><a href="#" title="Diagnósticos">Diagnósticos</a></li></ul>
			<ul class="nav"><li><a href="#" title="Medicamentos">Medicamentos</a></li></ul>
				
			<ul class="nav">
				<li><a href="#" title="Maestros">Maestros</a></li>
			</ul>
		</div>
		
        <div class="span5 search">	
        	<input class="span3" id="" name="search" placeholder="Introduzca su búsqueda..." type="text" />
        	<button id="inputsearch" class="btn primary">Buscar</button>
        </div>
    </div>

    <div class="row menu" title="menu">
     	<ul>
      		<li><span class="bold">Bienvenid@:</span> <a href="#"><?php print SESSION("ZanUser") ? SESSION("ZanUser") : "Anónimo"; ?></a></li>
      		<li><span class="bold">Centros:</span> <a href="#"><?php print $this->execute("Centers_Model", "count", NULL, "model"); ?></a></li>
  				<li><span class="bold">Diagnósticos:</span> <a href="#">0</a></li>
    			<li><span class="bold">Medicamentos:</span> <a href="#">0</a></li>
   				<li><span class="bold">Pacientes:</span> <a href="#"><?php print $this->execute("Users_Model", "count", array(4), "model"); ?></a></li> 
      		<li><span class="bold">Último Paciente:</span> <?php print $this->execute("Users_Model", "lastPacient", NULL, "model"); ?></li>
      		<li><span class="bold"><a href="<?php print path("cpanel/logout"); ?>">Desconectar</a></span></li>
      </ul>
    </div>
