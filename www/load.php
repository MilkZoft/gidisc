<?php 
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

ob_start(); 
session_start(); 

define("_dir", dirname(__FILE__));

date_default_timezone_set("America/Mexico_City");

if(file_exists(_dir . "/config/basics.php") and file_exists(_dir . "/config/core.php")) { 
	include "config/basics.php";
	include "config/core.php";
} else { 
	die("Error: basics.php or core.php doesn't exists");
}

if($ZP["production"]) { 
	error_reporting(FALSE);
	ini_set("display_errors", FALSE); 
} else {
	error_reporting(E_ALL);
}

include _corePath ."/classes/load.php";
include _corePath ."/classes/controller.php";
include _corePath ."/classes/model.php";

$Load = new ZP_Load(); 

$helpers = array("config", "i18n", "router", "benchmark", "exceptions", "string", "sessions", "security");

$Load->helper($helpers);

set("webLang", whichLanguage(FALSE));

if(get("translation") === "gettext") {
	$languageFile = _dir ."/lib/languages/gettext/". whichLanguage(TRUE, TRUE) .".mo";
		
	if(file_exists($languageFile)) { 			
		$Load->library("class.streams", NULL, NULL, "gettext");
		$Gettext_Reader = $Load->library("gettext", "Gettext_Reader", array($languageFile), "gettext");
		$Load->config("languages");
	
		$Gettext_Reader->load_tables();
	}
}

benchMarkStart();

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
header("Content-type: text/html; charset=utf-8");

error_reporting(E_ALL);

if(!version_compare(PHP_VERSION, "5.1.0", ">=")) {
	die("ZanPHP needs PHP 5.1.X or higher to run.");
}

if(COOKIE("ZanUser")) {
	SESSION("ZanUser", 		 COOKIE("ZanUser"));
	SESSION("ZanUserPwd",    COOKIE("ZanUserPwd"));
	SESSION("ZanUserID",     COOKIE("ZanUserID"));
	SESSION("ZanUserType",   COOKIE("ZanUserType"));
	SESSION("ZanUserTypeID", COOKIE("ZanUserTypeID"));
}

execute();

#print benchMarkEnd();