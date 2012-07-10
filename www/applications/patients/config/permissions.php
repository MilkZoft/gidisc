<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

function getPermissions() {
	if((int) SESSION("ZanUserTypeID") === 1) {
		return array(
			"Create" => TRUE,
			"Read"   => TRUE,
			"Update" => TRUE,
			"Delete" => TRUE
		);
	} elseif((int) SESSION("ZanUserTypeID") > 1) {
		return array(
			"Create" => FALSE,
			"Read"   => TRUE,
			"Update" => FALSE,
			"Delete" => FALSE
		); 
	} 

	return FALSE;
}