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
				</select>
			</p>
		</div>
		
		<!-- General inputs -->
		<div class="optiongeneral">
			<p>
				<span class="bold"><?php print __(_("Username")); ?></span><br />
				<input name="username" type="text" value="<?php print $username; ?>" tabindex="1" />
			</p>

			<p>
				<span class="bold"><?php print __(_("Password")); ?></span><br />
				<input name="pwd" type="password" value="<?php print $pwd; ?>" tabindex="2" />
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
				<input name="birthday" type="text" value="" tabindex="11" class="datepicker"/>
			</p>
			
			<p>
				<span class="bold"><?php print __(_("Photo")); ?></span><br />
				<input type="file" name="photo" />
			</p>
		</div>
		<!-- End general inputs -->
		
		<!-- Option 4 - Patients -->
		<div class="option4">
			<p>
				<span class="bold"><?php print __(_("Background")); ?></span><br />
				<textarea name="background" cols="10" rows="10"><?php print $background; ?></textarea tabindex="12" />
			</p>

			<p>
				<span class="bold"><?php print __(_("Center")); ?></span><br />
				<select name="center" tabindex="14" id="center">
					<?php foreach($centers as $center) { ?>
						<option value="<?php print $center["ID_Center"];?>"><?php print $center["Name"];?></option>
					<?php } ?>
				</select>
			</p>
			
			<p>
				<span class="bold"><?php print __(_("Therapist")); ?></span><br />
				<?php if($therapists) { ?>
					<select name="therapist" tabindex="14" id="v">
						<?php foreach($therapists as $therapist) { ?>
							<option value="<?php print $therapist["ID_Person"];?>"><?php print $therapist["Name"] . " " . $therapist["Last_Name"] . " " . $therapist["Maiden_Name"];?></option>
						<?php } ?>
					</select>
				<?php } ?>
				<span class="bold addtherapist blue"><?php print __(_("Add")); ?></span>
			</p>
						
			<p>
				<span class="bold"><?php print __(_("Father's Name")); ?></span><br />
				<input name="fname" type="text" value="<?php echo $fname; ?>" />
			</p>
			
			<p>
				<span class="bold"><?php print __(_("Mother's Name")); ?></span><br />
				<input name="mname" type="text" value="<?php echo $mname; ?>" />
			</p>
			
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
		<!-- End option 4 - Patients -->
		
		
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
