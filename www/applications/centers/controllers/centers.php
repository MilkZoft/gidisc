<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class Centers_Controller extends ZP_Controller {
	
	public function __construct() {		
		$this->Templates   = $this->core("Templates");
		$this->Users_Model = $this->model("Users_Model");
		
		$helpers = array("alerts", "router", "security", "sessions");
		$this->helper($helpers);
		
		$this->application = $this->app("users");
		
		$this->Templates->theme();
	}
	
	public function logout() {
		unsetSessions();
	}
		
	public function login($from = "users") {
		if(segment(3)) {
			$from = segment(3);
		} 
		
		$this->title("Login");
		$this->CSS("login", $this->application);
		
		if(POST("connect")) {
			if($this->Users_Model->isAdmin() or $this->Users_Model->isMember()) {
				$user = $this->Users_Model->getUserData();
			} else {
				$user = FALSE;
			}
			
			if($user) {
				SESSION("ZanUser", $user[0]["Username"]);
				SESSION("ZanUserPwd", $user[0]["Password"]);
				SESSION("ZanUserID", $user[0]["ID_User"]);
				SESSION("ZanUserType", $user[0]["Type"]);
				SESSION("ZanUserTypeID", $user[0]["ID_Type_User"]);
				
				redirect(POST("URL"));
			} elseif($from === "cpanel") {
				showAlert("Incorrect Login", _webBase . _sh . _webLang . _sh . _cpanel);
			} else {
				$vars["href"] 	= _webBase . _sh . _webLang . _sh . "users" . _sh . "login";
				$vars["alert"] 	= getAlert("Incorrect Login");
				$vars["view"]  	= $this->view("login", TRUE);
			}		
		} else {
			$vars["href"] = _webBase . _sh . _webLang . _sh . "users" . _sh . "login";
			$vars["view"] = $this->view("login", TRUE);
		}
		
		$this->render("content", $vars);
	}
	
}
