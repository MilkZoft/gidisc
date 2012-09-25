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
		$this->app("cpanel");
		
		$this->application = whichApplication();

		$this->config("cpanel");
		$this->helpers();
		$this->helper("cpanel", "cpanel");
		$this->permission   = getPermissions();
		
		$this->CPanel_Model = $this->model("CPanel_Model");
		$this->Users_Model  = $this->model("Users_Model");
		$this->isAdmin      = $this->Users_Model->isAdmin(TRUE);
		$this->Templates    = $this->core("Templates");

		$this->Templates->theme();
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
		
		$this->title("Add");
		
		$this->js("tiny-mce");
		$this->js("insert-html");
		$this->js("show-element");
		
		$this->CSS("forms", "cpanel");
		
		$this->vars["alert"] = FALSE;
		
		$Model = ucfirst($this->application) ."_Model";
		
		$this->$Model = $this->model($Model);
		
		if(POST("save")) {
			$save = $this->$Model->cpanel("save");
			$this->vars["alert"] = $save;
		} elseif(POST("cancel")) {
			redirect("pages/cpanel/");
		}
		
		$this->vars["view"] = $this->view("add", TRUE, $this->application);
		
		$this->render("content", $this->vars);
	}
	
	public function delete($ID = 0, $code = NULL) {
		if(!$this->isAdmin) {
			$this->login();
		}
		
		if(!is_null($code) and $code === SESSION("ZanUserCode")) {
			if($this->CPanel_Model->delete($ID)) {
				redirect($this->application ."/cpanel/results/trash");
			} else {
				redirect($this->application ."/cpanel/results/");
			}
		} else {
			redirect($this->application ."/cpanel/results/trash");
		}	
	}
	
	public function edit($ID = 0) {
		if(!$this->isAdmin) {
			$this->login();
		}
		
		if((int) $ID === 0) { 
			redirect($this->application ."/cpanel/results");
		}

		$this->title("Edit");
		
		$this->CSS("forms", "cpanel");
		$this->CSS("misc", "cpanel");
		
		$this->js("tiny-mce");
		$this->js("insert-html");
		$this->js("show-element");	
		
		$Model = ucfirst($this->application) ."_Model";
		
		$this->$Model = $this->model($Model);
		
		if(POST("edit")) {
			$this->vars["alert"] = $this->$Model->cpanel("edit");
		} elseif(POST("cancel")) {
			redirect("cpanel");
		} 
		
		$data = $this->$Model->getByID($ID);
		
		if($data) {
			$this->vars["data"] = $data;
			$this->vars["view"] = $this->view("add", TRUE, $this->application);
			
			$this->render("content", $this->vars);
		} else {
			redirect($this->application ."/cpanel/results");
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
	
	public function restore($ID = 0, $code = NULL) { 
		if(!$this->isAdmin) {
			$this->login();
		}
		
		if(!is_null($code) and $code === SESSION("ZanUserCode")) {
			if($this->CPanel_Model->restore($ID)) {
				redirect($this->application ."/cpanel/results/trash");
			} else {
				redirect($this->application ."/cpanel/results");
			}
		} else {
			redirect($this->application ."/cpanel/results/trash");
		}
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
			
			$trash = (segment(3, isLang()) === "trash") ? TRUE : FALSE;
					
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
	
	public function trash($ID = 0, $code) {
		if(!$this->isAdmin) {
			$this->login();
		}
		
		if(!is_null($code) and $code === SESSION("ZanUserCode")) {
			if($this->CPanel_Model->trash($ID)) {
				redirect($this->application ."/cpanel/results");
			} else {
				redirect($this->application ."/cpanel/add");
			}
		} else {
			redirect($this->application ."/cpanel/results");
		}
	}
	
}