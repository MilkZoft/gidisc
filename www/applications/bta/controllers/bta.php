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
		if(POST("age") >= 15 and POST("age") <= 84) {
			SESSION("btaAge", POST("age"));
			SESSION("btaURL", path("bta/finished"));

			$vars["swf"]  = path("swf/bta/bta.php", TRUE);
			$vars["view"] = $this->view("bta", TRUE);

			$this->render("content", $vars);
		} else {
			showAlert("Edad invalida", path("bta"));
		}
	}

	public function clean() {
		unset($_SESSION["btaCorrects"]);
		unset($_SESSION["btaLComplete"]);
		unset($_SESSION["btaNComplete"]);
	}

	public function finished() {
		if(POST("var_resp")) {
			$answers = str_replace("undefined|", "", POST("var_resp"));
			$answers = str_replace("|N|", "N|", $answers);

			$parts = explode("|", $answers);

			$correctsL = array("2", "3", "5", "4", "5", "7", "9", "6", "6", "12");
			$correctsN = array("2", "3", "4", "5", "7", "5", "6", "9", "12", "6");

			$corrects = (SESSION("btaCorrects") > 0) ? SESSION("btaCorrects") : 0;

			$type = $parts[0];

			array_shift($parts);
			
			if($type === "L") {
				if(!SESSION("btaLComplete")) {
					for($i = 0; $i <= 9; $i++) {
						if($parts[$i] == $correctsL[$i]) {
							$corrects++;
						}
					}
					
					SESSION("btaCorrects", $corrects);
					SESSION("btaLComplete", TRUE);
				}
			} elseif($type === "N") {
				if(!SESSION("btaNComplete")) {
					for($i = 0; $i <= 9; $i++) {
						if($parts[$i] == $correctsN[$i]) {
							$corrects++;
						}
					}
					
					SESSION("btaCorrects", $corrects);
					SESSION("btaNComplete", TRUE);
				}
			}

			if(SESSION("btaLComplete") and SESSION("btaNComplete")) { 
				$this->Bta_Model->setResult($corrects, SESSION("btaAge"));
			}
		}
	}

	public function result($result) {
		$vars["percentil"] = $result;
		$vars["view"] 	   = $this->view("result", TRUE);

		$this->render("content", $vars);
	}
}