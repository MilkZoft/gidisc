<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}

	$username   = $userPerson["Username"];
	$pwd  	    = $userPerson["Pwd"];
	$email      = $userPerson["Email"];
	$name 	    = $userPerson["Name"];
	$surname    = $userPerson["Surname"];
	$address 	= $userPerson["Address"];
	$phone 	    = $userPerson["Phone"];
	$grade 	    = $userPerson["Grade"];
	$profession = $userPerson["Profession"];
	$birthday 	= $userPerson["Birthday"];
	$background = $userPerson["Background"];
	$therapist  = $userPerson["Therapist"];
	$situation  = $userPerson["Situation"];
?>

<?php print isset($alert) ? $alert : NULL; ?>

<table class="zebra-striped">
	<tr>
		<td colspan="4"><center><img src="<?php print $userPhoto;?>" width="100px" height="100px" /></center></td>
	</tr>
	<tr>
		<td><b><?php print __(_("Username"));?></b></td>
		<td><?php print $username; ?></td>
		<td><b><?php print __(_("Email"));?></b></td>
		<td><?php print $email;?></td>
	</tr>
	<tr>
		<td><b><?php print __(_("Name"));?></b></td>
		<td><?php print $name; ?></td>
		<td><b><?php print __(_("Surname"));?></b></td>
		<td><?php print $surname;?></td>
	</tr>	
	<tr>
		<td><b><?php print __(_("Address"));?></b></td>
		<td><?php print $address; ?></td>
		<td><b><?php print __(_("Phone"));?></b></td>
		<td><?php print $phone;?></td>
	</tr>		
	<tr>
		<td><b><?php print __(_("Grade"));?></b></td>
		<td><?php print $grade; ?></td>
		<td><b><?php print __(_("Profession"));?></b></td>
		<td><?php print $profession;?></td>
	</tr>			
	<tr>
		<td><b><?php print __(_("Birthday"));?></b></td>
		<td><?php print $birthday; ?></td>
		<td><b><?php print __(_("Therapist"));?></b></td>
		<td><?php print $therapist;?></td>
	</tr>				
	<tr>
		<td><b><?php print __(_("Background"));?></b></td>
		<td colspan="3"><?php print $background; ?></td>
	</tr>
	<tr>
		<td><b><?php print __(_("Situation"));?></b></td>
		<td><?php print $situation; ?></td>
	</tr>	
</table>

