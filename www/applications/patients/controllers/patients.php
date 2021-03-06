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
		$start = 0;

		$this->CSS("pagination");
		$this->js("search", $this->application);

		if(segment(1, isLang()) === "page" and segment(2, isLang()) > 0) {
			$start = (segment(2, isLang()) * 25) - 25;
		}

		$limit = $start .", 25";	
		$count = $this->Patients_Model->count();
		$URL   = path("patients/page/");

		$pagination = ($count > 25) ? paginate($count, 25, $start, $URL) : NULL;

		$patients = $this->Patients_Model->all($limit);
		
		$vars["pagination"] = $pagination;
		$vars["patients"]   = $patients;
		$vars["view"] 	    = $this->view("home", TRUE);
		
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
