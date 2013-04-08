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
				<span class="bold"><?php print __(_("Select type user")); ?></span><br />
				<select name="type">
					<option value="" selected="selected"><?php print __(_("Select type"));?></option>
					<option value="2"><?php print __(_("Center"));?></option>
					<option value="3"><?php print __(_("Teacher"));?></option>
					<option value="4"><?php print __(_("Patient"));?></option>
					<option value="5"><?php print __(_("Parent"));?></option>
					<option value="6"><?php print __(_("Therapist"));?></option>
					<option value="7"><?php print __(_("Psychologist"));?></option>
					<option value="8"><?php print __(_("Doctor"));?></option>
				</select>
			</p>

			<p>
				<input name="continue" value="Continuar" type="submit" />
			</p>
		</div>
	</fieldset>
</form>