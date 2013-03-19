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

	<?php
		if($area < 32) {
	?>
			<div class="fecha"><span class="bold">Mes:</span> <?php print month($format["Month_"]);?></div>
	<?php
		} else {
	?>
			<div class="fecha"><span class="bold">Fecha:</span> <?php print decode($format["Text_Date"]);?></div>
	<?php
		}
	?>
		
	<div class="area"><span class="bold">Area:</span> <?php print decode($format["Name"]);?></div>

	<?php
	if($area < 32) {
	?>
	
		<div id="objetivos">
			<p class="bold">Objetivos:</p>
			<?php if($objectivesp) { $i = 1; ?>
				<?php 
					foreach($objectivesp as $key => $objective) { ?>
						<span><?php print $i .". ". decode($objective["Objetive"]);?></span><br />
				<?php 
						$i++;
					} 
				?>
			<?php } ?>
		</div>
		
		<table>
			<tr>
				<th>Objetivo/D&iacute;a</th>
				<?php if (isset($answers[0])) foreach($answers[0] as $answer) { ?>
					<th><?php print $answer["Day_"];?></th>
				<?php } ?>
				<th>Observaci&oacute;n</th>
			</tr>
			
			<?php if (isset($answers)) foreach($answers as $key => $answer) { ?>
				<tr>
					<td><?php print ($key + 1);?></td>
					
					<?php foreach($answer as $value) { ?>
						<td><?php print $value["Rating"];?></td>
					<?php } ?>
					
					<td class="observaciones"><?php print $objectivesp[$key]["Comments"];?></td>
				</tr>
			<?php } ?>			
			
		</table>
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