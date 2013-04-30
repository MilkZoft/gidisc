<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}

	if($edit) {
		$ID 	    = $data["ID_User"];
		$username   = recoverPOST("username", $data["Username"]);
		$pwd  	    = recoverPOST("pwd", $data["Pwd"]);
		$email      = recoverPOST("email", $data["Email"]);
		$name 	    = recoverPOST("name", $data["Name"]);
		$fname      = recoverPOST("fname", $data["Father_Name"]);
		$mname      = recoverPOST("mname", $data["Mother_Name"]);
		$lastName   = recoverPOST("last_name", $data["Last_Name"]);
		$maidenName = recoverPOST("maiden_name", $data["Maiden_Name"]);
		$address 	= recoverPOST("address", $data["Address"]);
		$phone 	    = recoverPOST("phone", $data["Phone"]);
		$grade 	    = recoverPOST("grade", $data["Grade"]);
		$birthday 	= recoverPOST("birthday", $data["Birthday"]);
		$background = recoverPOST("background", $data["Background"]);
		$ceo        = recoverPOST("ceo", $data["CEO"]);
		$levels     = recoverPOST("levels", $data["Levels"]);
		$coordinator = recoverPOST("coordinator", $data["Coordinator"]);
		$levels_directors = recoverPOST("levels_directors", $data["Levels_Directors"]);
		$contact    = recoverPOST("contact", $data["Contact"]);
		$action	    = "edit";
		$href	    = path("users/cpanel/edit/". $ID);
	} 
?>

<?php print isset($alert) ? $alert : NULL; ?>

<form action="<?php $href; ?>" enctype="multipart/form-data" method="POST"/>
	<fieldset>		
		<!-- General inputs -->
		<div class="optiongeneral">
			<h3>Agregar un usuario tipo centro</h3>

			<input name="id_type_user" value="<?php echo $type; ?>" type="hidden" />

			<p>
				<span class="bold">Usuario</span><br />
				<input name="username" type="text" value="<?php print $username; ?>" tabindex="1" />
			</p>

			<p>
				<span class="bold">Contraseña (Dejarla en blanco si no se quiere actualizar)</span><br />
				<input name="pwd" type="password" value="" tabindex="2" />
			</p>

			<p>
				<span class="bold"><?php print __(_("Email")); ?></span><br />
				<input name="email" type="text" value="<?php print $email; ?>" tabindex="3" />
			</p>

			<p>
				<span class="bold">Nombre</span><br />
				<input name="name" type="text" value="<?php print $name; ?>" tabindex="4" />
			</p>

			<p>
				<span class="bold">Apellido Paterno</span><br />
				<input name="last_name" type="text" value="<?php print $lastName; ?>" tabindex="5" />
			</p>
			
			<p>
				<span class="bold">Apellido Materno</span><br />
				<input name="maiden_name" type="text" value="<?php print $maidenName; ?>" tabindex="5" />
			</p>

			<p>
				<span class="bold">Teléfono</span><br />
				<input name="phone" type="text" value="<?php print $phone; ?>" tabindex="7" />
			</p>

			<p>
				<span class="bold">Niveles</span><br />
				<input name="levels" type="text" value="<?php print $levels; ?>" tabindex="7" />
			</p>

			<p>
				<span class="bold">Director General</span><br />
				<input name="ceo" type="text" value="<?php print $ceo; ?>" tabindex="7" />
			</p>

			<p>
				<span class="bold">Director (es) por Nivel</span><br />
				<input name="levels_directors" type="text" value="<?php print $levels_directors; ?>" tabindex="7" />
			</p>

			<p>
				<span class="bold">Coordinador</span><br />
				<input name="coordinator" type="text" value="<?php print $coordinator; ?>" tabindex="7" />
			</p>

			<p>
				<span class="bold">Contacto</span><br />
				<input name="contact" type="text" value="<?php print $contact; ?>" tabindex="7" />
			</p>
		</div>

		<p>
			<?php print formSave($action, FALSE); 
			print formInput(array("name" => "ID", "type" => "hidden", "value" => $ID)); 
			?>
		</p>
	</fieldset>	
</form>