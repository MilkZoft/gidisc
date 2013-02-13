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

<?php print isset($alert) ? $alert : NULL; ?>

<div id="all">
	<?php
		if($area < 32) {	
	?>
			<div id="top">
				<span>
					<h2>ÁREA <?php print $format["Name"];?>:</h2>
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
						Año: <input name="year" class="span1" maxlength="4" value="<?php echo $format["Year"]; ?>" /> 
						Mes:
						<?php 
						print formSelect(array("id" => "month", "name" => "month", "disabled" => "disabled"), $month);	
						?>
					</span>
					
					<div class="field">
						<?php print formLabel("terapist", "Terapeuta", FALSE);?>
						<select name="terapist" disabled="disabled">

							<?php 
								if(SESSION("ZanUserTypeID") == 6) {
								?>
									<option value="<?php print SESSION("ZanUserID");?>"><?php print SESSION("ZanUser"); ?></option>	
								<?php
								} else { 
									foreach($therapists as $therapist) { ?>
									<?php if($format["ID_Therapist"] == $therapist["ID_User"]) { ?>
										<option selected="selected" value="<?php print $therapist["ID_User"]?>"><?php print $therapist["Name"] . " " . $therapist["Last_Name"] . " " . $therapist["Maiden_Name"]; ?></option>
									<?php } else { ?>
										<option value="<?php print $therapist["ID_User"]?>"><?php print $therapist["Name"] . " " . $therapist["Last_Name"] . " " . $therapist["Maiden_Name"]; ?></option>
									<?php } ?>
								<?php 
									} 
								} 
							?>

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
						
					</div>
					
					<table id="goals-table">
						<tr>
							<th>ID</th>
							<th>Objetivo</th>
						</tr>
						<?php if($objectivesp) { ?>
							<?php foreach($objectivesp as $key => $objective) { ?>
								<tr class="molde1">
									<td><input class="id-goal" disabled="disabled" type="text" value="<?php print $key + 1;?>" /></td>
									<td><input name="objective[]" type="text" value="<?php print $objective["Objetive"];?>"/></td>
								</tr>
							<?php } ?>
						<?php } else { ?>
							<tr class="molde1">
								<td><input class="id-goal" disabled="disabled" type="text" value="1" /></td>
								<td><input name="objective[]" type="text" value=""/></td>
							</tr>
						<?php } ?>
					</table>
				</div>
				
				<div id="goals">
					<p>
						A - Falto pero si Aviso <br />
						V - Vacaciones <br />
						E - Enfermo <br />
						F - Falto <br />
						R - Reposición <br />
						X - No se trabajo ese objetivo
					</p>
					<table id="goals-explain">
						<?php if($answers) { ?>
							<tr>
								<th>Objetivo/Día</th>
								<?php for($i = 0; $i <= 14; $i++) { ?>
									<th><input name="day[0]" type="text" maxlength="2" value="<?php print (isset($answers[0][$i])) ? $answers[0][$i]["Day_"] : '';?>" /></th>
								<?php } ?>
								
								<th>Observaciones</th>
							</tr>
							
							<?php foreach($answers as $key => $answer) { ?>
								<?php 
									foreach($answer as $key2 => $value) {
										$var  = "day". ($key2 + 1);
										$$var = $value["Rating"]; 
									}
								?>
								<tr class="molde">
									<td><input class="goal" disabled="disabled" type="text" value="<?php print $key + 1;?>" /></td>
									<td><input name="days[0][]" type="text" maxlength="1" value="<?php print (isset($day1)) ? $day1 : NULL; ?>" /></td>
									<td><input name="days[1][]" type="text" maxlength="1" value="<?php print (isset($day2)) ? $day2 : NULL; ?>" /></td>
									<td><input name="days[2][]" type="text" maxlength="1" value="<?php print (isset($day3)) ? $day3 : NULL; ?>" /></td>
									<td><input name="days[3][]" type="text" maxlength="1" value="<?php print (isset($day4)) ? $day4 : NULL; ?>" /></td>
									<td><input name="days[4][]" type="text" maxlength="1" value="<?php print (isset($day5)) ? $day5 : NULL; ?>" /></td>
									<td><input name="days[5][]" type="text" maxlength="1" value="<?php print (isset($day6)) ? $day6 : NULL; ?>" /></td>
									<td><input name="days[6][]" type="text" maxlength="1" value="<?php print (isset($day7)) ? $day8 : NULL; ?>" /></td>
									<td><input name="days[7][]" type="text" maxlength="1" value="<?php print (isset($day8)) ? $day9 : NULL; ?>" /></td>
									<td><input name="days[8][]" type="text" maxlength="1" value="<?php print (isset($day9)) ? $day9 : NULL; ?>" /></td>
									<td><input name="days[9][]" type="text" maxlength="1" value="<?php print (isset($day10)) ? $day10 : NULL; ?>" /></td>
									<td><input name="days[10][]" type="text" maxlength="1" value="<?php print (isset($day11)) ? $day11 : NULL; ?>" /></td>
									<td><input name="days[11][]" type="text" maxlength="1" value="<?php print (isset($day12)) ? $day12 : NULL; ?>" /></td>
									<td><input name="days[12][]" type="text" maxlength="1" value="<?php print (isset($day13)) ? $day13 : NULL; ?>" /></td>
									<td><input name="days[13][]" type="text" maxlength="1" value="<?php print (isset($day14)) ? $day14 : NULL; ?>" /></td>
									<td><input name="days[14][]" type="text" maxlength="1" value="<?php print (isset($day15)) ? $day15 : NULL; ?>" /></td>
									<td><textarea class="obsv" name="obsv[]"><?php print $objectivesp[$key]["Comments"];?></textarea></td>
								</tr>
							<?php } ?>
						<?php } else { ?>
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
								<td><input name="days[0][]" type="text" maxlength="1" value="" /></td>
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
						<?php } ?>
					</table>
				</div>
				<p>
					<span>Observaciones: </span><br />
					<textarea class="obsv" disabled="disabled" name="comments"><?php print $format["Comments"];?></textarea>
				</p>
				
				<p>
					<span>Trabajo en casa: </span><br />
					<textarea class="obsv" disabled="disabled" name="work"><?php print $format["Work_Home"];?></textarea>
				</p>
			</form>
	<?php
		} else {
	?>
			<div id="top">
				<span>
					<h2>ÁREA: <?php print $format["Name"];?></h2>
				</span>
			</div>
			
			<form method="POST" action="">
				<p>
					<span>Observaciones: </span><br />
					<textarea class="obsv" disabled="disabled" name="comments"><?php print $format["Comments"];?></textarea>
				</p>
			</form>
	<?php
		}
	?>
</div>
	





