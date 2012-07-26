<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class Peabody_Controller extends ZP_Controller {

	static $data = NULL;

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
				redirect("peabody/image/0/". POST("age"));
			} else {
				showAlert("La edad es inválida", path("peabody"));
			}
		}
	}

	public function image($number, $age = 0) {
		if($age > 0) {
			$data = $this->Peabody_Model->getWords($age);
			
			$this->Peabody_Model->setTemporal($data);

			redirect("peabody/image/". $data["Start"]);
		} else {
			$data = $this->Peabody_Model->getTemporal();
			____($data->Words1[0]->Word);
		}
	}

	public function show($number, $word) {
		$vars["number"] = $number;
		$vars["word"]   = $word;
		$vars["view"] 	= $this->view("image", TRUE);

		$this->render("content", $vars);
	}
	
}
