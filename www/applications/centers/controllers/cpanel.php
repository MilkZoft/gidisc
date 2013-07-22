<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

include "www/applications/users/config/permissions.php";

class CPanel_Controller extends ZP_Controller {
	
	private $vars = array();
	
	public function __construct() {		
		$this->app("centers");

		$this->application = whichApplication();

		$this->config("cpanel");
		$this->config("permissions", "users");
		$this->helpers();
		$this->helper("cpanel", "cpanel");
		$this->permission   = getPermissions();
		
		$this->CPanel_Model  = $this->model("CPanel_Model");
		$this->Centers_Model = $this->model("Centers_Model");
		$this->Users_Model   = $this->model("Users_Model");
		$this->isAdmin       = $this->Users_Model->isAdmin(TRUE);
		$this->Templates     = $this->core("Templates");

		$this->Templates->theme(get("webTheme"));
	}
	
	public function index() {
		if($this->isAdmin) {
			$this->results();
		} else {
			$this->login();
		}
	}
	
	public function add() {
		if(!$this->isAdmin) {
			$this->login();
		}
		
		if($this->permission["Create"]) {	
			$this->title("Add");
					
			$this->CSS("forms", "cpanel");
			
			$Model = ucfirst($this->application) ."_Model";
			
			$this->$Model = $this->model($Model);
			
			if(POST("save")) {
				$save = $this->$Model->cpanel("save");
				
				$vars["alert"] = $save;
			} elseif(POST("cancel")) {
				redirect("centers/cpanel/");
			}
			
			$centers = $this->$Model->getTypesCenters();
			
			if(!$centers) {
				redirect("centerscpanel");
			}
			
			foreach($centers as $center) {
				$vars["centers"][] = array(
					"option" => $center["Type"],
					"value"  => $center["ID_Type_Center"]
				);
			}
			
			$vars["situations"][] = array(
				"option" => __("Active"),
				"value"  => "Active"
			);
			
			$vars["situations"][] = array(
				"option" => __("Inactive"),
				"value"  => "Inactive"
			);
			
			$vars["edit"] = FALSE;		
			$vars["view"] = $this->view("add", TRUE, "centers");
			
			$this->render("content", $vars);
		} else {
			$this->render("error404");
		}
	}
	
	public function delete($ID = 0, $code = NULL) {
		if(!$this->isAdmin) {
			$this->login();
		}
		
		if(!is_null($code) and $code === SESSION("ZanUserCode")) {
			if($this->CPanel_Model->delete($ID)) {
				redirect(get("webBase") . _sh . get("webLang") . _sh . $this->application . _sh . "cpanel" . _sh . get("results") . _sh . get("trash"));
			} else {
				redirect(get("webBase") . _sh . get("webLang") . _sh . $this->application . _sh . "cpanel" . _sh . get("results"));
			}
		} else {
			redirect(get("webBase") . _sh . get("webLang") . _sh . $this->application . _sh . "cpanel" . _sh . get("results") . _sh . get("trash"));
		}
	}
	
	public function edit($ID = 0) {
		if(!$this->isAdmin) {
			$this->login();
		}
		
		if($this->permission["Update"]) {	
			$this->title("Update");
					
			$this->CSS("forms", "cpanel");
			
			$Model = ucfirst($this->application) ."_Model";
			
			$this->$Model = $this->model($Model);
			
			$center = $this->$Model->getByID($ID);
			
			if(!$center) {
				redirect("centers/cpanel");
			}
			
			if(POST("edit")) {
				$save = $this->$Model->cpanel("edit");
				$vars["alert"] = $save;
			} elseif(POST("cancel")) {
				redirect("cpanel");
			}
			
			$center 		= $this->$Model->getByID($ID);
			$vars["center"] = $center[0];
			
			if($center[0]["Situation"] === "Active") {
				$vars["situations"][] = array(
					"option"   => __("Active"),
					"value"    => "Active",
					"selected" => TRUE
				);
				
				$vars["situations"][] = array(
					"option" => __("Inactive"),
					"value"  => "Inactive"
				);
			} else {
				$vars["situations"][] = array(
					"option"   => __("Active"),
					"value"    => "Active"
				);
				
				$vars["situations"][] = array(
					"option"   => __("Inactive"),
					"value"    => "Inactive",
					"selected" => TRUE
				);
			}
			
			$centers = $this->$Model->getTypesCenters();
			
			if(!$centers) {
				redirect("centers/cpanel");
			}
			
			foreach($centers as $center) {
				$vars["centers"][] = array(
					"option" => $center["Type"],
					"value"  => $center["ID_Type_Center"]
				);
			}
			
			$vars["edit"] = TRUE;		
			$vars["view"] = $this->view("add", "centers");
			
			$this->render("content", $vars);
		} else {
			$this->render("error404");
		}
	}

	public function login() {
		$this->title("Login");
		$this->CSS("login", "users");
		
		if(POST("connect")) {	
			$this->Users_Controller = $this->controller("Users_Controller");
			
			$this->Users_Controller->login("cpanel");
		} else {
			$vars["URL"]  = getURL();
			$this->view("login", $vars, "cpanel");
		}

		exit;
	}
	
	public function results() {
		if(!$this->isAdmin) {
			$this->login();
		}
		
		if($this->permission["Read"]) {
			if(POST("trash") and POST("records")) {
				foreach(POST("records") as $record) {
					$this->CPanel_Model->trash($record);
				}
			} elseif(POST("restore") and POST("records")) {
				foreach(POST("records") as $record) {
					$this->CPanel_Model->restore($record);
				}
			} elseif(POST("delete") and POST("records")) {
				foreach(POST("records") as $record) {
					$this->CPanel_Model->delete($record);
				}
			}
			
			$this->title("Manage ". $this->application);
			$this->CSS("results", "cpanel");
			$this->CSS("pagination");
			$this->js("checkbox");
			
			$this->helper("inflect");		
			
			$trash = (segment(3) === "trash") ? TRUE : FALSE;
			
			$total 		= $this->CPanel_Model->total($trash);
			$thead 		= $this->CPanel_Model->thead("checkbox, ". getFields($this->application) .", Action", FALSE);
			$pagination = $this->CPanel_Model->getPagination($trash);
			
			$tFoot 		= getTFoot($trash);
			
			$this->vars["message"]    = (!$tFoot) ? "Error" : NULL;
			$this->vars["pagination"] = $pagination;
			$this->vars["trash"]  	  = $trash;	
			$this->vars["search"] 	  = getSearch(); 
			$this->vars["table"]      = getTable(__("Manage " . ucfirst($this->application)), $thead, $tFoot, $total);
			$this->vars["view"]       = $this->view("results", TRUE, "cpanel");
			
			$this->render("content", $this->vars);
		}
	}
	
	public function show($ID) {
		if(!$this->isAdmin) {
			$this->login();
		}
		
		if($this->permission["Read"]) {	
			$this->title("View");
					
			$this->CSS("forms", "cpanel");
			
			$Model = ucfirst($this->application) ."_Model";
			
			$this->$Model = $this->model($Model);
			
			$center = $this->$Model->getByID($ID);
			
			if(!$center) {
				redirect("centers/cpanel");
			}
			
			$vars["center"] = $center[0];
		
			$centers = $this->$Model->getTypesCenters();
			
			if(!$centers) {
				redirect("centers/cpanel");
			}
			
			$vars["type"] = "Undefined";
			
			foreach($centers as $center) {
				if($center["ID_Type_Center"] === $vars["center"]["ID_Type_Center"]) {
					$vars["type"] = $center["Type"];
				}
			}

			$vars["users"] = $this->$Model->getUsers($ID);
			
			$vars["edit"] = TRUE;	
			$vars["view"] = $this->view("view", TRUE, "centers");
			
			$this->render("content", $vars);
		} else {
			$this->render("error404");
		}
	}

	public function restore($ID = 0, $code = NULL) { 
		if(!$this->isAdmin) {
			$this->login();
		}
		if(!is_null($code) and $code === SESSION("ZanUserCode")) {
			if($this->CPanel_Model->restore($ID)) {
				redirect(path($this->application . _sh . "cpanel" . _sh . get("results") . _sh . get("trash")));
			} else {
				redirect(path($this->application . _sh . "cpanel" . _sh . get("results")));
			}
		} else {
			redirect(path($this->application . _sh . "cpanel" . _sh . get("results") . _sh . get("trash")));
		}
	}

	public function trash($ID = 0, $code = NULL) {
		if(!$this->isAdmin) {
			$this->login();
		}
		
		if(!is_null($code) and $code === SESSION("ZanUserCode")) {
			if($this->permission["Delete"]) {
				if($this->CPanel_Model->trash($ID)) {
					redirect(path($this->application . _sh . "cpanel" . _sh . get("results")));
				} else {
					redirect(path($this->application . _sh . "cpanel" . _sh . get("add")));
				}
			}
		} else {
			redirect(path($this->application . _sh . "cpanel" . _sh . get("results")));
		}
	}
}