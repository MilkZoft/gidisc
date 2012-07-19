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
		if(POST("apply")) {
			$this->apply();
		} else {
			$vars["IDPatient"] = $IDPatient;
			$vars["tests"]     = $this->Quiz_Model->getAll();
			$vars["view"]      = $this->view("tests", TRUE);
			$this->render("content", $vars);
		}
	}
	
	public function apply() {
		if(POST("test") == 1) {
			redirect("quiz/d2/" . POST("IDPatient"));
		} elseif(POST("test") == 2) {
			redirect("quiz/peabody/" . POST("IDPatient"));
		} elseif(POST("test") == 3) {
			redirect("quiz/bta/" . POST("IDPatient"));;
		} elseif(POST("test") == 4) {
			redirect("quiz/cl/" . POST("IDPatient"));
		}
 	}
 	
 	public function d2() {
		$vars["view"] = $this->view("d2", TRUE);
		$this->render("content", $vars);
	}
	
	public function peabody() {
		$vars["view"] = $this->view("peabody", TRUE);
		$this->render("content", $vars);
	}
	
	public function bta() {
		$vars["view"] = $this->view("bta", TRUE);
		$this->render("content", $vars);
	}
	
	public function cl() {
		$vars["view"] = $this->view("cl", TRUE);
		$this->render("content", $vars);
	}
}
