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
		$href	    = _webBase . _sh . _webLang . _sh . "users" . _sh . _cpanel . _sh . "add";
	} else {
		$ID 	    = $userPerson["ID_User"];
		$username   = recoverPOST("username", $userPerson["Username"]);
		$pwd  	    = recoverPOST("pwd", $userPerson["Pwd"]);
		$email      = recoverPOST("email", $userPerson["Email"]);
		$name 	    = recoverPOST("name", $userPerson["Name"]);
		$lastName   = recoverPOST("last_name", $userPerson["Last_Name"]);
		$maidenName = recoverPOST("maiden_name", $userPerson["Maiden_Name"]);
		$address 	= recoverPOST("address", $userPerson["Address"]);
		$phone 	    = recoverPOST("phone", $userPerson["Phone"]);
		$grade 	    = recoverPOST("grade", $userPerson["Grade"]);
		$profession = recoverPOST("profession", $userPerson["Profession"]);
		$birthday 	= recoverPOST("birthday", $userPerson["Birthday"]);
		$background = recoverPOST("background", $userPerson["Background"]);
		$situation  = recoverPOST("situation", $userPerson["Situation"]);
		$action	    = "edit";
		$href	    = get("webBase") . _sh . get("webLang") . _sh . "users" . _sh . _cpanel . _sh . "edit" . _sh . $ID;
	} 
?>

<?php print isset($alert) ? $alert : NULL; ?>

<form action="<?php $href; ?>" enctype="multipart/form-data" method="POST"/>
	<fieldset>
		<legend></legend>
	
		<div>
			<p>
				<span class="bold"><?php print __(_("Select type user")); ?></span><br />
				<select name="type">
					<option value="2" <?php print ($userPerson["ID_Type_User"] == 2) ? 'selected="selected"' : "";?>><?php print __(_("Center"));?></option>
					<option value="3" <?php print ($userPerson["ID_Type_User"] == 3) ? 'selected="selected"' : "";?>><?php print __(_("Teacher"));?></option>
					<option value="4" <?php print ($userPerson["ID_Type_User"] == 4) ? 'selected="selected"' : "";?>><?php print __(_("Patient"));?></option>
					<option value="5" <?php print ($userPerson["ID_Type_User"] == 5) ? 'selected="selected"' : "";?>><?php print __(_("Parent"));?></option>
					<option value="6" <?php print ($userPerson["ID_Type_User"] == 6) ? 'selected="selected"' : "";?>><?php print __(_("Therapist"));?></option>
				</select>
			</p>
		</div>
		
		<!-- General inputs -->
		<div class="optiongeneral">
			<p>
				<span class="bold"><?php print __(_("Username")); ?></span><br />
				<input name="username" type="text" value="<?php print $username; ?>" tabindex="3" />
			</p>
			
			<p>
				<span class="bold"><?php print __(_("Password")); ?></span><br />
				<input name="pwd" type="password" value="<?php print $username; ?>" tabindex="3" />
			</p>
			
			<p>
				<span class="bold"><?php print __(_("Email")); ?></span><br />
				<input name="email" type="text" value="<?php print $email; ?>" tabindex="3" />
			</p>

			<p>
				<span class="bold"><?php print __(_("Name")); ?></span><br />
				<input name="name" type="text" value="<?php print $name; ?>" tabindex="4" />
			</p>

			<p>
				<span class="bold"><?php print __(_("Last name")); ?></span><br />
				<input name="last_name" type="text" value="<?php print $lastName; ?>" tabindex="5" />
			</p>
			
			<p>
				<span class="bold"><?php print __(_("Maiden name")); ?></span><br />
				<input name="maiden_name" type="text" value="<?php print $maidenName; ?>" tabindex="5" />
			</p>

			<p>
				<span class="bold"><?php print __(_("Address")); ?></span><br />
				<input name="address" type="text" value="<?php print $address; ?>" tabindex="6" />
			</p>

			<p>
				<span class="bold"><?php print __(_("Phone")); ?></span><br />
				<input name="phone" type="text" value="<?php print $phone; ?>" tabindex="7" />
			</p>

			<p>
				<span class="bold"><?php print __(_("Grade")); ?></span><br />
				<input name="grade" type="text" value="<?php print $grade; ?>" tabindex="9" />
			</p>

			<p>
				<span class="bold"><?php print __(_("Profession")); ?></span><br />
				<input name="profession" type="text" value="<?php print $profession; ?>" tabindex="10" />
			</p>

			<p>
				<span class="bold"><?php print __(_("Birthday")); ?></span><br />
				<input name="birthday" type="text" value="<?php print $birthday; ?>" tabindex="11" class="datepicker"/>
			</p>
			
			<p>
				<span class="bold"><?php print __(_("Photo")); ?></span><br />
				<input type="file" name="photo" />
			</p>
		</div>
		<!-- End general inputs -->
		
		
		<!-- Option 2,3,4,5,6 -->
		<div class="option2 option3 option5 option6">
			<p>
				<span class="bold"><?php print __(_("Situation")); ?></span><br />
				<select name="situation" tabindex="14" id="name">
					<option value="0">Seleccione la situación</option>
					<option value="1" selected="selected">Activo</option>
					<option value="2">Inactivo</option>
				</select>
			</p>
			
			<p>
				<?php print formSave($action, FALSE); 
				print formInput(array("name" => "ID", "type" => "hidden", "value" => $ID)); 
				?>
			</p>
		</div>
		<!-- End option 2,3,4,5,6 -->
		
	</fieldset>	
</form>
