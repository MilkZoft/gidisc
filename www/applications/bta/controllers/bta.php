<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class Bta_Controller extends ZP_Controller {
	public static $blocks = array();


	public function __construct() {
		$this->Templates   = $this->core("Templates");
		$this->Bta_Model = $this->model("Bta_Model");

		$this->helpers();
		
		$this->application = $this->app("bta");
		
		$this->Templates->theme();
	}
	
	public function index() {
		$vars["view"] = $this->view("bta", TRUE);

		$this->render("content", $vars);
	}	
}
