<form action="<?php echo path("patients/permissions/$IDPatient"); ?>" method="post">
	<?php
		$checked = NULL;

		foreach($all as $user) {
			if($user["ID_Type_User"] == 2) {
				$type = "Centro";
 			} elseif($user["ID_Type_User"] == 3) {
 				$type = "Maestro";
 			} elseif($user["ID_Type_User"] == 5) {
 				$type = "Familiar";
 			} elseif($user["ID_Type_User"] == 6) {
 				$type = "Terapeuta";
 			} elseif($user["ID_Type_User"] == 7) {
 				$type = "Psicólogo"
 			} elseif($user["ID_Type_User"] == 8) {
 				$type = "Médico";
 			}
 			
 			foreach($already as $person) {
 				if($person["ID_User"] === $user["ID_User"]) { 
 					$checked = ' checked="checked"';
 				} 
 			} 
		?>
			<input<?php echo $checked; ?> name="users[]" type="checkbox" value="<?php echo $user["ID_User"]; ?>" /> <?php echo $user["Username"]; ?> (<?php echo $type; ?>)<br />
		<?php

			$checked = NULL;
		}
	?>
	<br />
	<input name="ID_Patient" value="<?php echo $IDPatient; ?>" type="hidden" />
	
	<p>
		<input name="assign" value="Asignar Permisos" class="btn primary" type="submit" />
	</p>

	<p>
		<a href="<?php echo path("patients"); ?>">Regresar</a>
	</p>
</form>