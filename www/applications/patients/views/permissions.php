<form action="<?php echo path("patients/permissions/$IDPatient"); ?>" method="post">
	<?php
		$checked = NULL;
	?>

	<h2>Terapeutas</h2>
	<?php
	foreach($all as $user) {
		if($user["ID_Type_User"] == 6) {
			foreach($already as $person) {
				if($person["ID_User"] === $user["ID_User"]) { 
					$checked = ' checked="checked"';
				}
			}

			?><input<?php echo $checked; ?> name="users[]" type="checkbox" value="<?php echo $user["ID_User"]; ?>" /> <?php echo $user["Username"]; ?><br /><?php
		}
		?><?php
		$checked = NULL;
	}
	?>

	<h2>Maestros</h2>
	<?php
	foreach($all as $user) {
		if($user["ID_Type_User"] == 3) {
			foreach($already as $person) {
				if($person["ID_User"] === $user["ID_User"]) { 
					$checked = ' checked="checked"';
				}
			}

			?><input<?php echo $checked; ?> name="users[]" type="checkbox" value="<?php echo $user["ID_User"]; ?>" /> <?php echo $user["Username"]; ?><br /><?php
		}
		?><?php
		$checked = NULL;
	}
	?>

	<h2>Familiares</h2>
	<?php
	foreach($all as $user) {
		if($user["ID_Type_User"] == 5) {
			foreach($already as $person) {
				if($person["ID_User"] === $user["ID_User"]) { 
					$checked = ' checked="checked"';
				}
			}

			?><input<?php echo $checked; ?> name="users[]" type="checkbox" value="<?php echo $user["ID_User"]; ?>" /> <?php echo $user["Username"]; ?><br /><?php
		}
		?><?php
		$checked = NULL;
	}
	?>

	<h2>Psicólogos</h2>
	<?php
	foreach($all as $user) {
		if($user["ID_Type_User"] == 7) {
			foreach($already as $person) {
				if($person["ID_User"] === $user["ID_User"]) { 
					$checked = ' checked="checked"';
				}
			}

			?><input<?php echo $checked; ?> name="users[]" type="checkbox" value="<?php echo $user["ID_User"]; ?>" /> <?php echo $user["Username"]; ?><br /><?php
		}
		?><?php
		$checked = NULL;
	}
	?>

	<h2>Médicos</h2>
	<?php
	foreach($all as $user) {
		if($user["ID_Type_User"] == 8) {
			foreach($already as $person) {
				if($person["ID_User"] === $user["ID_User"]) { 
					$checked = ' checked="checked"';
				}
			}

			?><input<?php echo $checked; ?> name="users[]" type="checkbox" value="<?php echo $user["ID_User"]; ?>" /> <?php echo $user["Username"]; ?><br /><?php
		}
		?><?php
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