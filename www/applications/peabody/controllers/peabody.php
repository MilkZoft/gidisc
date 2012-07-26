<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class Peabody_Controller extends ZP_Controller {
	
	public function __construct() {
		$this->Templates   = $this->core("Templates");
		$this->Peabody_Model = $this->model("Peabody_Model");

		$this->helpers();
		
		$this->application = $this->app("peabody");
		
		$this->Templates->theme();
	}
	
	public function index() {
		if(!POST("start")) {
			$vars["view"] = $this->view("age", TRUE);

			$this->render("content", $vars);
		}
	}

	public function start() {
		if(POST("start")) {
			if(POST("age") >= 3 and POST("age") <= 14) {
				$data = $this->Peabody_Model->getWords(POST("age"));

				____($data);
			} else {
				showAlert("La edad es inválida", path("peabody"));
			}
		}
	}
	
}
