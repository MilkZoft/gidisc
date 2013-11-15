<form action="<?php echo path("patients/centers/$IDPatient/$type"); ?>" method="post">
	<?php
		$checked = NULL;
		if (is_array($all))
		foreach($all as $center) { 			
 			foreach($already as $person) {
 				if($person["ID_Center"] === $center["ID_Center"]) { 
 					$checked = ' checked="checked"';
 				} 
 			} 

 			if ($type >= 6) {
 				$fType = "checkbox";
 			} else {
 				$fType = "radio";
 			}
		?>
			<input<?php echo $checked; ?> name="centers[]" type="<?=$fType;?>" value="<?php echo $center["ID_Center"]; ?>" /> <?php echo $center["Name"]; ?><br />
		<?php

			$checked = NULL;
		}
	?>
	<br />
	<input name="ID_Patient" value="<?php echo $IDPatient; ?>" type="hidden" />
	
	<p>
		<input name="assign" value="Asignar Centro" class="btn primary" type="submit" />
	</p>

	<p>
		<a href="<?php echo path("patients"); ?>">Regresar</a>
	</p>
</form>