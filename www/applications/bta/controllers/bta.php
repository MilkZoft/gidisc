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
		$vars["view"] = $this->view("age", TRUE);

		$this->render("content", $vars);
	}

	public function start() {
		if(POST("age") >= 17 and POST("age") <= 84) {
			SESSION("btaAge", POST("age"));
			SESSION("btaURL", path("bta/finished"));

			$vars["swf"]  = path("swf/bta/bta.php", TRUE);
			$vars["view"] = $this->view("bta", TRUE);

			$this->render("content", $vars);
		} else {
			showAlert("Edad invalida", path("bta"));
		}
	}

	public function test() {
		$answers = "L|1|1|1|1|1|1|1|1|1|1";

		$answers = str_replace("undefined|", "", $answers);

		$parts = explode("|", $answers);

		$correctsL = array("2", "3", "5", "4", "5", "7", "9", "6", "6", "12");
		$correctsN = array("2", "3", "4", "5", "7", "5", "6", "9", "12", "6");

		$corrects = (SESSION("btaCorrects") > 0) ? SESSION("btaCorrects") : 0;

		$type = $parts[0];

		array_shift($parts);

		if($type === "L") {
			for($i = 0; $i <= 10; $i++) {
				if($parts[$i] === $correctsL[$i]) {
					$corrects++;
				}
			}

			SESSION("btaCorrects", $corrects);
			SESSION("btaLComplete", TRUE);
		} elseif($type === "N") {
			for($i = 0; $i <= 10; $i++) {
				if($parts[$i] === $correctsN[$i]) {
					$corrects++;
				}
			}

			SESSION("btaCorrects", $corrects);
			SESSION("btaNComplete", TRUE);
		}

		if(SESSION("btaLComplete") and SESSION("btaNComplete")) {
			$this->Bta_Model->setResult($corrects, SESSION("btaAge"));
		}

	}

	public function finished() {
		die(var_dump($_POST));
	}
}
