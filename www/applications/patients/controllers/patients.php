<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class Patients_Controller extends ZP_Controller {

	public function __construct() {		
		$this->Templates      = $this->core("Templates");
		$this->Patients_Model = $this->model("Patients_Model");

		$this->helpers();
		$this->helper("pagination");
		$this->CSS("default");
		
		$this->application = $this->app("patients");
		
		$this->Templates->theme();
	}
	
	public function index() {
		if(segment(1, isLang()) === "page" and segment(2, isLang()) > 0) {
			$start = (segment(2, isLang()) * 25) - 25;
		} else {
			$start = 0;
		}

		$limit = $start .", 25";			
		$URL   = path("patients/page/");
	
		if(POST("seek")) {
			$patients = $this->Patients_Model->search(POST("name"));			
			$count = count($patients);
		} else {
			$patients = $this->Patients_Model->all($limit);
			$count = $this->Patients_Model->count();
		}

		$start = 0;

		$this->CSS("pagination");
		$this->js("search", $this->application);

		$pagination = ($count > 25) ? paginate($count, 25, $start, $URL) : NULL;
		
		$vars["pagination"] = $pagination;
		$vars["patients"]   = $patients;
		$vars["view"] 	    = $this->view("home", TRUE);
		
		$this->render("content", $vars);	
	}

	public function permissions($IDPatient) {
		if(POST("assign")) {
			$this->Patients_Model->assignPermissions();
		}

		$all = $this->Patients_Model->getByType("2, 3, 5, 6");
		$already = array();

		foreach($all as $user) {
			$assigned = $this->Patients_Model->getAssigned($user["ID_User"], $IDPatient);

			if($assigned) {
				$already[] = $assigned[0];
			}
		}

		$vars["already"]   = $already;
		$vars["all"]       = $all;
		$vars["IDPatient"] = $IDPatient;
		$vars["view"]      = $this->view("permissions", TRUE);

		$this->render("content", $vars);
	}
	
	public function area($IDPatient) {
		$this->Test_Model = $this->model("Test_Model");
		
		$areas = $this->Test_Model->getLastAreas();
		
		$vars["areas"] 	   = $areas;
		$vars["IDPatient"] = $IDPatient;
		$vars["view"]  	   = $this->view("areas", TRUE);
		$this->render("content", $vars);	
	}
	
	public function test() {
		if(POST("send") or POST("save")) {
			$this->title("Form");
			$this->CSS("styles", "test");
			$this->js("actions", "test");
			
			$this->Test_Model = $this->model("Test_Model");
			
			$area 		= $this->Test_Model->getArea(POST("area"));
			$objectives = $this->Test_Model->getObjectives(POST("area"));
			$therapists = $this->Patients_Model->getByType();
			$patient    = $this->Patients_Model->getPatient(POST("IDPatient"));
			
			if(POST("save")) {
				$save = $this->Test_Model->save();
				$vars["alert"] = $save;
			}

			$vars["area"] 	    = $area;
			$vars["objectives"] = $objectives;
			$vars["therapists"] = $therapists;
			$vars["patient"]    = $patient;
			
			$vars["view"]  	    = $this->view("test", TRUE);

			$this->render("content", $vars);	
		} else {
			redirect("patients/");
		}
	}
}
