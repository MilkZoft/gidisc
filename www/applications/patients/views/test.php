<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
	
	$month[0]["option"] = "Enero";      $month[0]["value"] = 1;   $month[0]["selected"] = ((int) date("m") == 1) ? TRUE : FALSE;
	$month[1]["option"] = "Febrero";    $month[1]["value"] = 2;   $month[1]["selected"] = ((int) date("m") == 2) ? TRUE : FALSE;
	$month[2]["option"] = "Marzo";      $month[2]["value"] = 3;   $month[2]["selected"] = ((int) date("m") == 3) ? TRUE : FALSE;
	$month[3]["option"] = "Abril";      $month[3]["value"] = 4;   $month[3]["selected"] = ((int) date("m") == 4) ? TRUE : FALSE;
	$month[4]["option"] = "Mayo";       $month[4]["value"] = 5;   $month[4]["selected"] = ((int) date("m") == 5) ? TRUE : FALSE;
	$month[5]["option"] = "Junio";      $month[5]["value"] = 6;   $month[5]["selected"] = ((int) date("m") == 6) ? TRUE : FALSE;
	$month[6]["option"] = "Julio";      $month[6]["value"] = 7;   $month[6]["selected"] = ((int) date("m") == 7) ? TRUE : FALSE;
	$month[7]["option"] = "Agosto";     $month[7]["value"] = 8;   $month[7]["selected"] = ((int) date("m") == 8) ? TRUE : FALSE;
	$month[8]["option"] = "Septiembre"; $month[8]["value"] = 9;   $month[8]["selected"] = ((int) date("m") == 9) ? TRUE : FALSE;
	$month[9]["option"] = "Octubre";    $month[9]["value"] = 10;  $month[9]["selected"] = ((int) date("m") == 10) ? TRUE : FALSE;
	$month[10]["option"] = "Noviembre"; $month[10]["value"] = 11; $month[10]["selected"] = ((int) date("m") == 11) ? TRUE : FALSE;
	$month[11]["option"] = "Diciembre"; $month[11]["value"] = 12; $month[11]["selected"] = ((int) date("m") == 12) ? TRUE : FALSE;
?>

<?php print isset($alert) ? $alert : NULL; ?>
<style>
	#bloque { float:left; width:100%; margin:30px 0 0 50px; }
	#bloque p { float:left; width:100%; margin-top:10px; }
	#bloque span { width:300px; height:auto; }
	.clave { float:left; margin-top:30px; width:100%; }
	.claves { float:left; width:100%; }
	.claves span { float:left; width:100% !important; margin:10px 0 0 75px; }
	.upercase { text-transform:uppercase; }
</style>
<div id="all">
	<?php 
	
	if($area["ID_Area"] < 32) {
	?>
		<div id="top">
			<span>
				<h2>ÁREA <?php print $area["Name"];?>:</h2>
			</span>

			<span class="objetivo-general">
				<h3>OBJETIVO GENERAL: </h3>
				<?php if($objectives) { ?>
					<ol class="objetivo-list">
						<?php foreach($objectives as $objective) { ?>
							<li class="item"><a><?php print $objective["Name"];?></a></li>
						<?php } ?>
					</ol>
				<?php } ?>
			</span>
		</div>
		
		<form method="POST" action="">
			
			<div id="section-top">
				
				<span class="field">
					Año: <input name="year" class="span1" maxlength="4" value="<?php echo date("Y"); ?>" /> 
					Mes:
					<?php
					print formSelect(array("id" => "month", "name" => "month"), $month);	
					?>
				</span>
				
				<div class="field">
					<?php print formLabel("terapist", "Terapeuta", FALSE);?>
					<select name="terapist">
						<?php foreach($therapists as $therapist) { ?>
							<option value="<?php print $therapist["ID_User"]?>"><?php print $therapist["Name"] . " " . $therapist["Last_Name"] . " " . $therapist["Maiden_Name"]; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			
			<div id="section-bottom">
				<span class="field bold">
					Nombre: <?php print $patient["Name"] . " " . $patient["Last_Name"] . " " . $patient["Maiden_Name"]; ?>
				</span>
			</div>
			
			<div id="objetivos">
				<div id="controls">
					<button class="action-button" id="addObjectivo">Agregar</button>
					<button class="action-button" id="removeObjectivo">Remover</button>
				</div>
				
				<table id="goals-table">
					<tr>
						<th>ID</th>
						<th>Objetivo</th>
					</tr>
					
					<tr class="molde1">
						<td><input class="id-goal" disabled="disabled" type="text" value="1" /></td>
						<td><input name="objective[]" type="text" value=""/></td>
					</tr>
					
				</table>
			</div>
			
			<div id="goals">
				<table id="goals-explain">
					<tr>
						<th>Objetivo/Día</th>
						<th><input name="day[0]" type="text" maxlength="2" value="" /></th>
						<th><input name="day[1]" type="text" maxlength="2" value="" /></th>
						<th><input name="day[2]" type="text" maxlength="2" value="" /></th>
						<th><input name="day[3]" type="text" maxlength="2" value="" /></th>
						<th><input name="day[4]" type="text" maxlength="2" value="" /></th>
						<th><input name="day[5]" type="text" maxlength="2" value="" /></th>
						<th><input name="day[6]" type="text" maxlength="2" value="" /></th>
						<th><input name="day[7]" type="text" maxlength="2" value="" /></th>
						<th><input name="day[8]" type="text" maxlength="2" value="" /></th>
						<th><input name="day[9]" type="text" maxlength="2" value="" /></th>
						<th><input name="day[10]" type="text" maxlength="2" value="" /></th>
						<th><input name="day[11]" type="text" maxlength="2" value="" /></th>
						<th><input name="day[12]" type="text" maxlength="2" value="" /></th>
						<th><input name="day[13]" type="text" maxlength="2" value="" /></th>
						<th><input name="day[14]" type="text" maxlength="2" value="" /></th>
						<th>Observaciones</th>
					</tr>
					
					<tr class="molde">
						<td><input class="goal" disabled="disabled" type="text" value="1" /></td>
						<td><input name="days[0][]" type="text" value="" /></td>
						<td><input name="days[1][]" type="text" maxlength="1" value="" /></td>
						<td><input name="days[2][]" type="text" maxlength="1" value="" /></td>
						<td><input name="days[3][]" type="text" maxlength="1" value="" /></td>
						<td><input name="days[4][]" type="text" maxlength="1" value="" /></td>
						<td><input name="days[5][]" type="text" maxlength="1" value="" /></td>
						<td><input name="days[6][]" type="text" maxlength="1" value="" /></td>
						<td><input name="days[7][]" type="text" maxlength="1" value="" /></td>
						<td><input name="days[8][]" type="text" maxlength="1" value="" /></td>
						<td><input name="days[9][]" type="text" maxlength="1" value="" /></td>
						<td><input name="days[10][]" type="text" maxlength="1" value="" /></td>
						<td><input name="days[11][]" type="text" maxlength="1" value="" /></td>
						<td><input name="days[12][]" type="text" maxlength="1" value="" /></td>
						<td><input name="days[13][]" type="text" maxlength="1" value="" /></td>
						<td><input name="days[14][]" type="text" maxlength="1" value="" /></td>
						<td><textarea class="obsv" name="obsv[]"></textarea></td>
					</tr>
					
				</table>
			</div>
			
			<div id="bloque" class="claves">
				<div class="clave"><span class="upercase">claves</span>: 0 = no puede</div>
				<span>1 = lo realiza el 25% de las veces </span>
				<span>2 = lo realiza el 50% de las veces </span>
				<span>3 = lo realiza el 75% de las veces </span>
				<span> 4 =  lo realiza el 100% de las veces</span>
			</div>
		
			<p>
				<span>Observaciones: </span><br />
				<textarea class="obsv" name="comments"></textarea>
			</p>
			
			<p>
				<span>Trabajo en casa: </span><br />
				<textarea class="obsv" name="work"></textarea>
			</p>
			
			<p>
				<input type="hidden" value="<?php print $patient["ID_User"];?>" name="IDPatient">
				<input type="hidden" value="<?php print $area["ID_Area"];?>" name="area">
				<input id="send" class="btn btn-success" type="submit" value="<?php print __("Send");?>" name="save">
			</p>
		</form>
	<?php
		} else {
	?>
		<div id="top">
			<span>
				<h2>ÁREA: <?php print $area["Name"];?></h2>
			</span>
		</div>
		
		<form method="POST" action="">
			<p>
				<span>Observaciones: </span><br />
				<textarea class="obsv" name="comments"></textarea>
			</p>
			
			<p>
				<input type="hidden" value="<?php print $patient["ID_User"];?>" name="IDPatient">
				<input type="hidden" value="<?php print $area["ID_Area"];?>" name="area">
				<input id="send" class="btn btn-success" type="submit" value="<?php print __("Send");?>" name="save">
			</p>
		</form>
	<?php 
		}
	?>
</div>
	








