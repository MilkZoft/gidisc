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

	public function centers($IDPatient) {
		if (POST("assign")) {
			$this->Patients_Model->assignCenters();
		}

		$all = $this->Patients_Model->getCenters();
		$already = array();

		foreach ($all as $center) {
			$assigned = $this->Patients_Model->getAssignedCenters($center["ID_Center"], $IDPatient);

			if($assigned) {
				$already[] = $assigned[0];
			}
		}

		$vars["already"]   = $already;
		$vars["all"]       = $all;
		$vars["IDPatient"] = $IDPatient;
		$vars["view"]      = $this->view("centers", TRUE);

		$this->render("content", $vars);
	}

	public function permissions($IDPatient) {
		if(POST("assign")) {
			$this->Patients_Model->assignPermissions();
		}

		$all = $this->Patients_Model->getByType("2, 3, 5, 6, 7, 8");
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
		if(POST("send") or POST("save") or POST("edit")) {
			$this->title("Form");
			$this->CSS("styles", "test");
			$this->js("actions", "test");
			
			$this->Test_Model = $this->model("Test_Model");
			
			if(POST("IDPatient") and POST("area")) { 	
				$format = $this->Test_Model->getFormat(POST("IDPatient"), POST("area"));
				
				if(isset($format[0]["format"]) and $format[0]["format"]["ID_Area"] < 32) {
					if(POST("edit")) { 
						$edit = $this->Test_Model->editTest();
						$vars["alert"] = $edit;

						$patient    = $this->Patients_Model->getPatient($format[0]["format"]["ID_User"]);
						$objectives = $this->Test_Model->getObjectives($format[0]["format"]["ID_Area"]);
						$therapists = $this->Patients_Model->getByType();
					} else {
						$patient    = $this->Patients_Model->getPatient($format[0]["format"]["ID_User"]);
						$objectives = $this->Test_Model->getObjectives($format[0]["format"]["ID_Area"]);
						$therapists = $this->Patients_Model->getByType();
					}
					
					$vars["area"]		 = $format[0]["format"]["ID_Area"];
					$vars["format"]      = $format[0]["format"];
					$vars["objectives"]  = $objectives;
					$vars["therapists"]  = $therapists;
					$vars["objectivesp"] = $format[0]["objectives"];
					$vars["answers"]     = $format[0]["answers"];
					$vars["patient"]     = $patient;
					$vars["view"] 	     = $this->view("show", TRUE);
					
					$this->render("content", $vars);	
				} else {
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
				}
			} else {
				redirect("patients/");
			}
		}
	}
}
