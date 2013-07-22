<form action="<?php echo path("patients/centers/$IDPatient"); ?>" method="post">
	<?php
		$checked = NULL;

		foreach($all as $center) { 			
 			foreach($already as $person) {
 				if($person["ID_User"] === $user["ID_User"]) { 
 					$checked = ' checked="checked"';
 				} 
 			} 
		?>
			<input<?php echo $checked; ?> name="users[]" type="checkbox" value="<?php echo $center["ID_Center"]; ?>" /> <?php echo $center["Name"]; ?><br />
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