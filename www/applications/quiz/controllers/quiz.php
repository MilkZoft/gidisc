<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class Quiz_Controller extends ZP_Controller {
	
	public function __construct() {		
		$this->Templates  = $this->core("Templates");
		$this->Quiz_Model = $this->model("Quiz_Model");

		$this->helpers();
		$this->helper("pagination");
		$this->CSS("default");
		
		$this->application = $this->app("quiz");
		$this->pdf 		   = NULL;
		$this->Templates->theme();
	}
	
	public function index() {
		redirect("patients");
	}
	
	public function getAll($IDPatient = FALSE) {
		$vars["tests"] = $this->Quiz_Model->getAll();
		$vars["view"]  = $this->view("tests", TRUE);
		$this->render("content", $vars);
	}
}
