<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class CPanel_Controller extends ZP_Controller {
	
	public function __construct() {
		$this->app("cpanel");

		$this->config("cpanel");

		$this->CPanel_Model = $this->model("CPanel_Model");
		$this->Users_Model  = $this->model("Users_Model");
		$this->isAdmin      = $this->Users_Model->isAdmin(TRUE);
		$this->Templates    = $this->core("Templates");

		$this->Templates->theme();
	}
	
	public function index() {
		if($this->isAdmin) {
			if((int) SESSION("ZanUserTypeID") === 1) {
				$this->home();
			} elseif((int) SESSION("ZanUserTypeID") === 4) {
				$this->tests();
			}
		} else {
			$this->login();
		}
	}

	public function tests() {

	}

	public function home() {
		$this->title("Home");
		$this->CSS();
		
		$this->helper("porlets", $this->application);
		
		$this->vars["lastUsers"]   = porlet(__("Last users"), $this->CPanel_Model->home("users"));
		$this->vars["lastCenters"] = porlet(__("Last centers"), $this->CPanel_Model->home("centers"), "list", "right");
		$this->vars["view"] 	   = $this->view("home", TRUE);
		
		$this->render("content", $this->vars);
	}

	public function login() {
		$this->title("Login");
		$this->CSS("login", "users");
		
		if(POST("connect")) {	
			$this->Users_Controller = $this->controller("Users_Controller");
			
			$this->Users_Controller->login("cpanel"); 
		} else {
			$vars["URL"]  = getURL();
			$this->view("login", $vars);
		}
	}
	
	public function logout() {
		unsetSessions("cpanel");
	}
}