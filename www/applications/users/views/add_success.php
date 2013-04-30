<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}

	if(!$edit) {
		$ID 	    = 0;
		$username   = recoverPOST("username");
		$pwd        = recoverPOST("pwd");
		$email      = recoverPOST("email");
		$name       = recoverPOST("name");
		$fname      = recoverPOST("fname");
		$mname      = recoverPOST("mname");
		$lastName   = recoverPOST("last_name");
		$maidenName = recoverPOST("maiden_name");
		$address    = recoverPOST("address");
		$phone      = recoverPOST("phone");
		$grade      = recoverPOST("grade");
		$profession = recoverPOST("profession");
		$birthday   = recoverPOST("birthday");
		$background = recoverPOST("background");
		$therapist  = recoverPOST("therapist");
		$situation  = recoverPOST("situation");		
		$action	    = "save";
		$href	    = path("users/cpanel/add");
	} else {
		$ID 	    = $userPerson["ID_User"];
		$username   = recoverPOST("username", $userPerson["Username"]);
		$pwd  	    = recoverPOST("pwd", $userPerson["Pwd"]);
		$email      = recoverPOST("email", $userPerson["Email"]);
		$name 	    = recoverPOST("name", $userPerson["Name"]);
		$fname      = recoverPOST("fname", $userPerson["Father_Name"]);
		$mname      = recoverPOST("mname", $userPerson["Mother_Name"]);
		$lastName   = recoverPOST("last_name", $userPerson["Last_Name"]);
		$maidenName = recoverPOST("maiden_name", $userPerson["Maiden_Name"]);
		$address 	= recoverPOST("address", $userPerson["Address"]);
		$phone 	    = recoverPOST("phone", $userPerson["Phone"]);
		$grade 	    = recoverPOST("grade", $userPerson["Grade"]);
		$profession = recoverPOST("profession", $userPerson["Profession"]);
		$birthday 	= recoverPOST("birthday", $userPerson["Birthday"]);
		$background = recoverPOST("background", $userPerson["Background"]);
		$therapist  = recoverPOST("therapist", $userPerson["Therapist"]);
		$situation  = recoverPOST("situation", $userPerson["Situation"]);
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

			<p>
				<span class="bold">Centro</span><br />
				<select name="center" tabindex="14" id="center">
					<?php foreach($centers as $center) { ?>
						<option value="<?php print $center["ID_Center"];?>"><?php print $center["Name"];?></option>
					<?php } ?>
				</select>
			</p>

			<p>
				<span class="bold">Usuario</span><br />
				<input name="username" type="text" value="<?php print $username; ?>" tabindex="1" />
			</p>

			<p>
				<span class="bold">Contraseña</span><br />
				<input name="pwd" type="password" value="<?php print $pwd; ?>" tabindex="2" />
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
				<input name="levels" type="text" value="<?php print $ceo; ?>" tabindex="7" />
			</p>

			<p>
				<span class="bold">Director General</span><br />
				<input name="ceo" type="text" value="<?php print $ceo; ?>" tabindex="7" />
			</p>

			<p>
				<span class="bold">Director (es) por Nivel</span><br />
				<input name="levels_directors" type="text" value="<?php print $ceo; ?>" tabindex="7" />
			</p>

			<p>
				<span class="bold">Coordinador</span><br />
				<input name="coordinator" type="text" value="<?php print $ceo; ?>" tabindex="7" />
			</p>

			<p>
				<span class="bold">Contacto</span><br />
				<input name="contact" type="text" value="<?php print $ceo; ?>" tabindex="7" />
			</p>
		</div>

		<p>
			<?php print formSave($action, FALSE); 
			print formInput(array("name" => "ID", "type" => "hidden", "value" => $ID)); 
			?>
		</p>
	</fieldset>	
</form>