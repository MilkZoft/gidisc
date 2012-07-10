<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}
	
	if(!$edit) {
		$ID 	  = 0;
		$name 	  = recoverPOST("name");
		$address  = recoverPOST("address");
		$country  = recoverPOST("country");
		$district = recoverPOST("district");
		$phone    = recoverPOST("phone");
		$contact  = recoverPOST("contact");
		$action	  = "save";
		$href	  = get("webBase") . _sh . get("webLang") . _sh . "centers" . _sh . "cpanel" . _sh . "add";
	} else {
		$ID 	  = $center["ID_Center"];
		$name 	  = $center["Name"];
		$address  = $center["Address"];
		$country  = $center["Country"];
		$district = $center["District"];
		$phone    = $center["Phone"];
		$contact  = $center["Contact"];
		$action	  = "edit";
		$href	  = get("webBase") . _sh . get("webLang") . _sh . "centers" . _sh . "cpanel" . _sh . "edit" . _sh . $ID;
	} 

	print div("add-form", "class");
		print formOpen($href, "form-add", "form-add");
			
			print p(__(_(ucfirst(whichApplication()))), "resalt");
			
			print isset($alert) ? $alert : NULL;

			print formInput(array("name" => "name", "field" => __(_("Name")), "p" => TRUE, "value" => $name));
			
			print formInput(array("name" => "address", "field" => __(_("Address")), "p" => TRUE, "value" => $address));

			print formInput(array("name" => "district", "field" => __(_("District")), "p" => TRUE, "value" => $district));
			
			print formInput(array("name" => "country", "field" => __(_("Country")), "p" => TRUE, "value" => $country));
			
			print formInput(array("name" => "phone", "field" => __(_("Phone")), "p" => TRUE, "value" => $phone));
			
			print formTextarea(array("name" => "contact", "field" => __(_("Contact")), "p" => TRUE, "value" => $contact));
			
			print formSelect(array("name" => "type", "field" => __(_("Type")), "p" => TRUE), $centers);
			
			print formSelect(array("name" => "situation", "field" => __(_("Situation")), "p" => TRUE), $situations);
			
			print formSave($action, FALSE);
			
			print formInput(array("name" => "ID", "type" => "hidden", "value" => $ID));
		print formClose();
	print div(FALSE);
