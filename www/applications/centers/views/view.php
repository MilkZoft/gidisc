<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
	
	$ID 	   = $center["ID_Center"];
	$name 	   = $center["Name"];
	$address   = $center["Address"];
	$country   = $center["Country"];
	$district  = $center["District"];
	$phone     = $center["Phone"];
	$contact   = $center["Contact"];
	$situation = $center["Situation"];
	$href	   = get("webBase") . _sh . get("webLang") . _sh . "centers" . _sh . "cpanel" . _sh . "results" . _sh;

	die(var_dump($users));
?>	
	<div class="span6">
		<h4><?php print __(_("Name"));?></h4>
		<p><?php print $name;?></p>
	</div>
	
	<div class="span6">
		<h4><?php print __(_("Address"));?></h4>
		<p><?php print $address;?></p>
	</div>
	
	<div class="span6">
		<h4><?php print __(_("District"));?></h4>
		<p><?php print $district;?></p>
	</div>
	
	<div class="span6">
		<h4><?php print __(_("Country"));?></h4>
		<p><?php print $country;?></p>
	</div>
	
	<div class="span6">
		<h4><?php print __(_("Phone"));?></h4>
		<p><?php print $phone;?></p>
	</div>
	
	<div class="span6">
		<h4><?php print __(_("Contact"));?></h4>
		<p><?php print $contact;?></p>
	</div>
	
	<div class="span6">
		<h4><?php print __(_("Type"));?></h4>
		<p><?php print $type;?></p>
	</div>
	
	<div class="span6">
		<h4><?php print __(_("Situation"));?></h4>
		<p><?php print $situation;?></p>
	</div>
	
	<a href="<?php print $href;?>" title="<?php print __(_("Return"));?>"><?php print __(_("Return"));?></a>
