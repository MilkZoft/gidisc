<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class Ajax_Controller extends ZP_Controller {
	
	public function __construct() {		
		$this->application  = $this->app("search");
		$this->Users_Model  = $this->model("Users_Model");
		$this->isAdmin      = $this->Users_Model->isAdmin(TRUE);
	}
	
	public function search() {
		if($this->isAdmin) {
			if(trim(POST("search")) !== "") {
				$this->Centers_Model = $this->model("Centers_Model");
				$vars["response"]["centers"] = $this->Centers_Model->search(trim(POST("search")));
				
				$this->Users_Model = $this->model("Users_Model");
				$vars["response"]["users"] = $this->Users_Model->search(trim(POST("search")));
				
				$this->Pages_Model = $this->model("Pages_Model");
				$vars["response"]["pages"] = $this->Pages_Model->search(trim(POST("search")));
				
				if(!$vars["response"]["centers"] and !$vars["response"]["users"] and !$vars["response"]["pages"]) {
					$vars["response"] = FALSE;
				}
			} else {
				$vars["response"] = FALSE;
			}
			
			echo json_encode($vars);
		} else {
			redirect("cpanel");
		}
	}
	
	public function patients() {
		if($this->isAdmin) {
			if(trim(POST("search")) !== "") {
				$this->Patients_Model = $this->model("Patients_Model");
				$vars["response"]["patients"] = $this->Patients_Model->search(trim(POST("search")));
				
				if(!$vars["response"]["patients"]) {
					$vars["response"] = FALSE;
				}
			} else {
				$vars["response"] = FALSE;
			}
			
			echo json_encode($vars);
		} else {
			redirect("cpanel");
		}
	
	}
}
