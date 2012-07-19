<form method="POST" action="">
	<span class="field">Selecciona una prueba: </span>
	
	<select name="test" id="test">
		<?php foreach($tests as $test) { ?>
			<option value="<?php echo $test["ID_Type_Test"];?>"><?php echo $test["Type"];?></option>
		<?php } ?>
	</select>
	
	<p>
		<input type="hidden" value="<?php print $ID_Patient;?>" name="IDPatient">
		<input id="send" class="btn btn-success" type="submit" value="<?php print __("Iniciar prueba");?>" name="save">
	</p>
</form>
