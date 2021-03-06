<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class CPanel_Controller extends ZP_Controller {
	
	private $vars = array();
	
	public function __construct() {		
		$this->app("cpanel");

		$this->application = whichApplication();

		$this->config("cpanel");
		$this->config("permissions", "users");
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
			redirect("cpanel");
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
			$this->js("typeuser", $this->application);
			
			$Model = ucfirst($this->application) ."_Model";
			
			$this->$Model = $this->model($Model);
			
			$this->Centers_Model = $this->model("Centers_Model");
			
			if(POST("save")) {
				$save = $this->$Model->cpanel("save");

				$vars["alert"] = $save;
			} elseif(POST("cancel")) {
				redirect("cpanel");
			}
			
			$vars["centers"]    = $this->Centers_Model->all();
			$vars["typeUsers"]  = $this->$Model->getTypesUsers();
			$vars["fathers"]    = $this->$Model->getByType(5);
			$vars["therapists"] = $this->$Model->getByType(6);
			
			$vars["edit"] = FALSE;		
			$vars["view"] = $this->view("add", TRUE, $this->application);
			
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
				redirect(path($this->application ."/cpanel/results/trash"));
			} else {
				redirect(path($this->application ."/cpanel/results"));
			}
		} else {
			redirect(path($this->application ."/cpanel/results/trash"));
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
			
			$users = $this->$Model->getByID("users", $ID);

			if(!$users) {
				redirect("users/cpanel");
			}
			
			if(POST("edit")) {
				$save = $this->$Model->cpanel("edit");
				$vars["alert"] = $save;
			} elseif(POST("cancel")) {
				redirect("cpanel");
			}

			$reUserPerson = $this->$Model->getReUserPerson($ID);			

			$vars["reUserPerson"] = $reUserPerson[0];

			$ID_User 	= segment(4);
			$ID_Person  = $reUserPerson[0]["ID_Person"];
			$userPerson = $this->$Model->getUserPerson($ID_User);

			$vars["userPerson"]    = $userPerson[0];

			if($users[0]["Situation"] === "Active") {
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
			
			$users = $this->$Model->getTypesUsers();

			if(!$users) {
				redirect("users" . _sh . "cpanel");
			}

			foreach($users as $user) {
				$vars["users"][] = array(
					"option" => $user["Type"],
					"value"  => $user["ID_Type_User"]
				);
			}
			
			$vars["edit"] = TRUE;
			
			if($vars["userPerson"]["ID_Type_User"] === 4) {
				$vars["view"] = $this->view("editpatient", TRUE, "users");
			} else {		
				$vars["view"] = $this->view("edit", TRUE, "users");
			}
			
			$this->render("content", $vars);
		} else {
			$this->render("error404");
		}
	}

	public function profile($ID = 0) {
		if(!$this->isAdmin) {
			$this->login();
		}
		
		if($this->permission["Read"]) {
			
			$this->title("Profile ". $this->application);

			$this->CSS("forms", "cpanel");
			
			$Model = ucfirst($this->application) ."_Model";
			
			$this->$Model = $this->model($Model);
			
			$users = $this->$Model->getByID("users", $ID);

			$reUserPerson = $this->$Model->getReUserPerson($ID);

			$ID_Person  = $reUserPerson[0]["ID_Person"];
			$userPerson = $this->$Model->getUserPerson($ID);
			$getPhoto 	= $this->$Model->getPhoto($userPerson[0]["ID_Patient"]);
			
			$vars["userPerson"] = $userPerson[0];
			$dir 				= _webURL."/www/lib/files/images/users/photos/";
			$vars["userPhoto"] 	= $dir.$getPhoto[0]["url"];
			
			if(!$users) {
				redirect("users" . _sh . "cpanel");
			}

			$vars["view"] = $this->view("profile", "users");
			
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
				redirect(path($this->application ."/cpanel/results/trash"));
			} else {
				redirect(path($this->application ."/cpanel/results"));
			}
		} else {
			redirect(path($this->application ."/cpanel/results/trash"));
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
	
	public function trash($ID = 0, $code = NULL) {
		if(!$this->isAdmin) {
			$this->login();
		}
		
		if(!is_null($code) and $code === SESSION("ZanUserCode")) {
			if($this->permission["Delete"]) {
				if($this->CPanel_Model->trash($ID)) {
					redirect(path($this->application ."/cpanel/results"));
				} else {
					redirect(path($this->application ."/cpanel/add"));
				}
			}
		} else {
			redirect(path($this->application ."/cpanel/results"));
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

}