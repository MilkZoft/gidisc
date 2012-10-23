<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
	
	$month[0]["option"] = "Enero";      $month[0]["value"] = 1;   $month[0]["selected"] = ($format["Month_"] == 1) ? TRUE : FALSE;
	$month[1]["option"] = "Febrero";    $month[1]["value"] = 2;   $month[1]["selected"] = ($format["Month_"] == 2) ? TRUE : FALSE;
	$month[2]["option"] = "Marzo";      $month[2]["value"] = 3;   $month[2]["selected"] = ($format["Month_"] == 3) ? TRUE : FALSE;
	$month[3]["option"] = "Abril";      $month[3]["value"] = 4;   $month[3]["selected"] = ($format["Month_"] == 4) ? TRUE : FALSE;
	$month[4]["option"] = "Mayo";       $month[4]["value"] = 5;   $month[4]["selected"] = ($format["Month_"] == 5) ? TRUE : FALSE;
	$month[5]["option"] = "Junio";      $month[5]["value"] = 6;   $month[5]["selected"] = ($format["Month_"] == 6) ? TRUE : FALSE;
	$month[6]["option"] = "Julio";      $month[6]["value"] = 7;   $month[6]["selected"] = ($format["Month_"] == 7) ? TRUE : FALSE;
	$month[7]["option"] = "Agosto";     $month[7]["value"] = 8;   $month[7]["selected"] = ($format["Month_"] == 8) ? TRUE : FALSE;
	$month[8]["option"] = "Septiembre"; $month[8]["value"] = 9;   $month[8]["selected"] = ($format["Month_"] == 9) ? TRUE : FALSE;
	$month[9]["option"] = "Octubre";    $month[9]["value"] = 10;  $month[9]["selected"] = ($format["Month_"] == 10) ? TRUE : FALSE;
	$month[10]["option"] = "Noviembre"; $month[10]["value"] = 11; $month[10]["selected"] = ($format["Month_"] == 11) ? TRUE : FALSE;
	$month[11]["option"] = "Diciembre"; $month[11]["value"] = 12; $month[11]["selected"] = ($format["Month_"] == 12) ? TRUE : FALSE;
	
?>
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
	table .observaciones { max-width:300px; height:auto; }
	table tr th { border:3px solid #ccc; }
	table tr td { border:3px solid #ccc; text-align:center; }
	#bloque { float:left; width:100%; margin:30px 0 0 50px; }
	#bloque p { float:left; width:100%; margin-top:10px; }
	#bloque span { width:300px; height:auto; }
	.clave { float:left; margin-top:20px; width:100%; }
	.claves { float:left; width:100%; }
	.claves span { float:left; width:100% !important; margin:10px 0 0 75px; }
	.upercase { text-transform:uppercase; }
	img  { width:150px; height:68px; }
	#objetivos { float:left; margin-left:50px; }
</style>

<div id="download">
	<div id="header">
	
		<img class="logo" src="<?php print dirname(__FILE__) . "/css/images/logo.png" ;?>" />
		<span class="title upercase">Tabla de seguimiento</span>
	</div>
	
	<div id="datos">
		<div class="renglon">
			<div class="nombre">
				<span class="bold">Nombre:</span> <?php print decode($patient["Name"] . " " . $patient["Last_Name"] . " " . $patient["Maiden_Name"]); ?>
			</div>
			<?php
				if($area < 32) {
			?>
					<span><span class="bold">Mes:</span> <?php print month($format["Month_"]);?></span>
			<?php
				} else {
			?>
					<span class="bold">Fecha:</span> <?php print decode($format["Text_Date"]);?>
			<?php
				}
			?>
		</div>
		<div class="renglon">
			<div class="nombre">
				<?php foreach($therapists as $therapist) { ?>
					<?php if($format["ID_Therapist"] == $therapist["ID_User"]) { ?>
						<span class="bold">Terapeuta:</span> <?php print decode($therapist["Name"] . " " . $therapist["Last_Name"] . " " . $therapist["Maiden_Name"]); ?>
					<?php } ?>
				<?php } ?>
			</div>
			
			<span><span class="bold">Area:</span> <?php print decode($format["Name"]);?></span>
		</div>
	</div>

	<?php
	if($area < 32) {
	?>
	
		<div id="objetivos">
			<p class="bold">Objetivos:</p>
			<?php if($objectivesp) { ?>
				<?php foreach($objectivesp as $key => $objective) { ?>
					<span><?php print decode($objective["Objetive"]);?></span><br />
				<?php } ?>
			<?php } ?>
		</div>
		
		<table>
			<tr>
				<th>Objetivo/D&iacute;a</th>
				<?php foreach($answers[0] as $answer) { ?>
					<th><?php print $answer["Day_"];?></th>
				<?php } ?>
				<th>Observaci&oacute;n</th>
			</tr>
			
			<?php foreach($answers as $key => $answer) { ?>
				<tr>
					<td><?php print ($key + 1);?></td>
					
					<?php foreach($answer as $value) { ?>
						<td><?php print (int) $value["Rating"];?></td>
					<?php } ?>
					
					<td class="observaciones"><?php print $objectivesp[$key]["Comments"];?></td>
				</tr>
			<?php } ?>			
			
		</table>
		
		<div id="bloque" class="claves">
			<div class="clave"><span class="upercase">claves</span>: 0 = no puede</div>
			<span>1 = lo realiza el 25% de las veces </span>
			<span>2 = lo realiza el 50% de las veces </span>
			<span>3 = lo realiza el 75% de las veces </span>
			<span> 4 =  lo realiza el 100% de las veces</span>
		</div>
	<?php
	}
	?>

	<div id="bloque">
		<p>
			<span class="bold">Observaciones: </span><br />
			<span><?php print decode($format["Comments"]);?></span>
		</p>
		<?php
		if($area < 32) {
		?>
			<p>
				<span class="bold">Trabajo en casa: </span><br />
				<span><?php print decode($format["Work_Home"]);?></span>
			</p>
		<?php
		}
		?>
	</div>
</div>
