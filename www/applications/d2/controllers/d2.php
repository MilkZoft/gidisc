<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class D2_Controller extends ZP_Controller {
	public static $blocks = array();


	public function __construct() {
		$this->Templates   = $this->core("Templates");
		$this->Bta_Model = $this->model("D2_Model");

		$this->helpers();
		
		$this->application = $this->app("d2");
		
		$this->Templates->theme();
	}
	
	public function index() {
		$this->start();
	}

	public function start() {
		$vars["swf"]  = path("swf/d2/d2.php", TRUE);
		$vars["view"] = $this->view("d2", TRUE);

		$this->render("content", $vars);
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