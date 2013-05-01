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
				$vars["view"] = $this->view("add_success", TRUE, $this->application);
			} elseif(POST("cancel")) {
				redirect("cpanel");
			} elseif(POST("continue")) {
				$vars["type"] = POST("type");
				
				if(POST("type") == 2) {
					$vars["centers"] = $this->Centers_Model->all();
					$vars["view"] 	 = $this->view("add_center", TRUE, $this->application);
				} elseif(POST("type") == 3) {
					$vars["view"] = $this->view("add_teacher", TRUE, $this->application);
				} elseif(POST("type") == 4) {
					$vars["fathers"] 	= $this->$Model->getByUsersType(5);
					$vars["therapists"] = $this->$Model->getByUsersType(6);
					$vars["view"] 		= $this->view("add_patient", TRUE, $this->application);
				} elseif(POST("type") == 5) {
					$vars["view"] = $this->view("add_parent", TRUE, $this->application);
				} elseif(POST("type") == 6) {
					$vars["view"] = $this->view("add_therapist", TRUE, $this->application);
				} elseif(POST("type") == 7) {
					$vars["view"] = $this->view("add_psychologist", TRUE, $this->application);
				} elseif(POST("type") == 8) {
					$vars["view"] = $this->view("add_doctor", TRUE, $this->application);
				}
				
				$vars["typeUsers"]  = $this->$Model->getTypesUsers();
				
				
			} else {
				$vars["view"] = $this->view("usertype", TRUE, $this->application);
			}
			
			$vars["edit"] = FALSE;		
			
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
			
			$data = $this->$Model->getByID("users", $ID);

			if(!$data) {
				redirect("users/cpanel");
			}
			
			if(POST("edit")) {
				$save = $this->$Model->cpanel("edit");
				$vars["alert"] = $save;
			} elseif(POST("cancel")) {
				redirect("cpanel");
			}

			$vars["therapists"] = $this->$Model->getByType(6);
			
			$vars["edit"] = TRUE;
			$vars["data"] = $data[0];
			$vars["type"] = $data[0]["ID_Type_User"];

			if($data[0]["ID_Type_User"] == 2) {
				$vars["view"] = $this->view("edit_center", TRUE, "users");
			} elseif($data[0]["ID_Type_User"] == 3) {
				$vars["view"] = $this->view("edit_teacher", TRUE, "users");
			} elseif($data[0]["ID_Type_User"] == 4) {
				$vars["view"] = $this->view("edit_patient", TRUE, "users");
			} elseif($data[0]["ID_Type_User"] == 5) {
				$vars["view"] = $this->view("edit_parent", TRUE, "users");
			} elseif($data[0]["ID_Type_User"] == 6) {
				$vars["view"] = $this->view("edit_therapist", TRUE, "users");
			} elseif($data[0]["ID_Type_User"] == 7) {
				$vars["view"] = $this->view("edit_psychologist", TRUE, "users");
			} elseif($data[0]["ID_Type_User"] == 8) {
				$vars["view"] = $this->view("edit_doctor", TRUE, "users");
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