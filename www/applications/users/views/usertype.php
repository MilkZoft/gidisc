<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}

	$href = path("users/cpanel/add"); 
?>

<?php print isset($alert) ? $alert : NULL; ?>

<form action="<?php $href; ?>" enctype="multipart/form-data" method="POST"/>
	<fieldset>
		<legend></legend>
	
		<div>
			<p>
				<span class="bold">Selecciona el tipo de usuario que quieres crear</span><br />
				<select name="type">
					<option value="" selected="selected">Tipo de usuairo</option>
					<option value="2">Centro</option>
					<option value="3">Maestro</option>
					<option value="4">Paciente</option>
					<option value="5">Familiar</option>
					<option value="6">Terapeuta</option>
					<option value="7">Psicógolo</option>
					<option value="8">Médico</option>
				</select>
			</p>

			<p>
				<input name="continue" value="Continuar" type="submit" />
			</p>
		</div>
	</fieldset>
</form>