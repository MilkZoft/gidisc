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
				redirect("peabody/image/0/". POST("age") ."/1");
			} else {
				showAlert("La edad es inválida", path("peabody"));
			}
		}
	}

	public function image($number, $age = 0, $start = FALSE) {
		if($start) {
			$data = $this->Peabody_Model->getWords($age);
			
			$this->Peabody_Model->setTemporal($data, "Data");

			redirect("peabody/image/". $data["Start"] ."/$age");
		} else {
			$data = $this->Peabody_Model->getTemporal();
			$answers = $this->Peabody_Model->getTemporal(1);

			if(POST("validate")) {
				if(POST("option") == $data["Words1"][POST("number") - 1]["Answer"]) {
					$answer["corrects"][POST("number") - 1] = POST("word");
					$ok = TRUE;
				} else {
					$answer["incorrects"][POST("number") - 1] = POST("word"); 
					$ok = FALSE;
				}
				
				$this->Peabody_Model->updateTemporal($answer, 1);

				if($ok) { 
					redirect("peabody/image/". (POST("number") + 1) ."/$age");
				} else {
					if($age == 3 or $age == 4) {
						redirect("peabody/image/". (POST("number") + 1) ."/$age");
					}
				}
			}
			
			$this->show($data["Words1"][$number - 1]["ID_Word"], $data["Words1"][$number - 1]["Word"], $age);
		}
	}

	public function show($number, $word, $age) {
		$vars["number"] = $number;
		$vars["word"]   = encode($word);
		$vars["age"]	= $age;
		$vars["view"] 	= $this->view("image", TRUE);

		$this->render("content", $vars);
	}
	
}
