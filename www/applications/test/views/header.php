<style>
	#download { float:left; width:100%; font-size:15px; }
	#header { float:left; width:100%;  }
	#header .title { float:left; margin:50px 0 0 150px; } 
	#header .logo { float:left; margin-left:10px; }
	#datos { width:100%; margin-top:30px; float:left; margin-left:50px; }
	#datos .renglon { float:left; width:100% }
	.bold { font-weight:bold; padding-right:5px; }
	.nombre { float:left; width:450px; }
	table { border:none; float:left; width:100%; margin:30px 0 0 50px; }
	table .observaciones { max-width:300px; height:auto; margin-left: 100px; }
	table tr th { border:3px solid #ccc; }
	table tr td { border:3px solid #ccc; text-align:center; }
	#bloque { float:left; width:100%; margin:10px 0 20px 50px; }
	#bloque p { float:left; width:100%; margin-top:10px; }
	#bloque span { width:300px; height:auto; }
	.clave { float:left; margin-top:20px; width:100%; }
	.claves { float:left; width:100%; }
	.claves span { float:left; width:100% !important; margin:10px 0 0 75px; }
	.upercase { text-transform:uppercase; }
	img  { width:150px; height:68px; }
	#objetivos { float:left;}
	.area {float: left; margin-left: 50px;}
	.fecha {float: left; margin-left: 50px;}
	.terapeuta {float:left; width:450px; margin-left: 50px;}
</style>

<div id="download">
	<div id="header">
	
		<img class="logo" src="<?php print dirname(__FILE__) . "/css/images/logo.png" ;?>" />
		<span class="title upercase">Tabla de seguimiento</span>
	</div>

	<div id="datos">
		<div class="nombre">
			<span class="bold">Nombre:</span> <?php print decode($patient["Name"] . " " . $patient["Last_Name"] . " " . $patient["Maiden_Name"]); ?>
		</div>
	</div>