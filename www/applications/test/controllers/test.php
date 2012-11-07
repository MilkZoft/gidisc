<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class Test_Controller extends ZP_Controller {
	
	public function __construct() {		
		$this->Templates  = $this->core("Templates");
		$this->Test_Model = $this->model("Test_Model");

		$this->helpers();
		$this->helper("pagination");
		$this->CSS("default");
		
		$this->application = $this->app("test");
		$this->pdf 		   = NULL;
		$this->Templates->theme();
	}
	
	public function index() {
		redirect("patients");
	}
	
	public function delete($IDPatient = 0, $IDFormat = FALSE, $code = NULL) {
		if(!is_null($code) and $code === SESSION("ZanUserCode")) {
			$this->Test_Model = $this->model("Test_Model");
			$delete = $this->Test_Model->delete($IDFormat);
			
			if(!$delete) {
				showAlert("An error occurred :(", path($this->application . _sh . "get" . _sh . $IDPatient));
			} else {
				showAlert("The test has been deleted correctly", path($this->application . _sh . "get" . _sh . $IDPatient));
			}
		} else {
			redirect(path($this->application . _sh . "get" . _sh . $IDPatient));
		}
	}
	
	public function edit($IDFormat = FALSE) {
		$this->title("Form");
		$this->CSS("styles", $this->application);
		$this->js("actions", $this->application);
			
		$this->Patients_Model = $this->model("Patients_Model");
		
		$format = $this->Test_Model->get($IDFormat);
		
		if($format and isset($format["format"]) and $format["format"]) {
			if(POST("edit")) {
				$save = $this->Test_Model->edit($IDFormat);
				$vars["alert"] = $save;
				
				$format = $this->Test_Model->get($IDFormat);
			}
			
			$patient    = $this->Patients_Model->getPatient($format["format"]["ID_Patient"]);
			$objectives = $this->Test_Model->getObjectives($format["format"]["ID_Area"]);
			$therapists = $this->Patients_Model->getByType();
			
			$vars["format"]      = $format["format"];
			$vars["objectives"]  = $objectives;
			$vars["therapists"]  = $therapists;
			$vars["objectivesp"] = $format["objectives"];
			$vars["answers"]     = $format["answers"];
			$vars["patient"]     = $patient;
			$vars["view"] 	     = $this->view("edit", TRUE);

			$this->render("content", $vars);	
		} else {
			redirect("patients");
		}
	}
	
	public function show($IDFormat = FALSE) {
		$this->title("Form");
		$this->CSS("styles", $this->application);
		$this->js("actions", $this->application);
			
		$this->Patients_Model = $this->model("Patients_Model");
		
		$format = $this->Test_Model->get($IDFormat);
		
		if($format and isset($format["format"]) and $format["format"]) {
			$patient    = $this->Patients_Model->getPatient($format["format"]["ID_Patient"]);
			$objectives = $this->Test_Model->getObjectives($format["format"]["ID_Area"]);
			$therapists = $this->Patients_Model->getByType();
			
			$vars["area"]		 = $format["format"]["ID_Area"];
			$vars["format"]      = $format["format"];
			$vars["objectives"]  = $objectives;
			$vars["therapists"]  = $therapists;
			$vars["objectivesp"] = $format["objectives"];
			$vars["answers"]     = $format["answers"];
			$vars["patient"]     = $patient;
			$vars["view"] 	     = $this->view("show", TRUE);
			
			$this->render("content", $vars);	
		} else {
			redirect("patients");
		}
	}
	
	private function setPDF($html, $name = "output.pdf") {
		require_once(dirname(__FILE__) . "/../libraries/dompdf/dompdf_config.inc.php");
		
		
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		//$dompdf->set_paper($_POST["paper"], $_POST["orientation"]);
		$dompdf->render();

		$dompdf->stream($name);
	}
	
	public function download($IDPatient = 0, $IDFormat = FALSE) {
		if(!$IDFormat) {
			redirect(path($this->application . _sh . "get" . _sh . $IDPatient));
		} 
			
		$formats = $this->Test_Model->get($IDFormat);
		
		if(!$formats) {
			redirect(path($this->application . _sh . "get" . _sh . $IDPatient));
		} else {
			$this->Patients_Model = $this->model("Patients_Model");
			$i = 0;
			
			ob_start();
			foreach($formats as $format) {
				if(isset($format["format"]) and is_array($format["format"])) {	
					$patientData    = $this->Patients_Model->getPatient($format["format"]["ID_Patient"]);
					$objectivesData = $this->Test_Model->getObjectives($format["format"]["ID_Area"]);
					$therapistsData = $this->Patients_Model->getByType();
				
					$vars["area"]		   = $format["format"]["ID_Area"]; 			
					$vars["format"]        = $format["format"];
					$vars["objectives"]    = $objectivesData;
					$vars["therapists"]    = $therapistsData;
					$vars["objectivesesp"] = $format["objectives"];
					$vars["answers"]       = $format["answers"];
					$vars["patient"]       = $patientData;
					
					if($i == 0) {
						$view  = $this->view("header", $vars, $this->application, TRUE);
						$view .= $this->view("download", $vars, $this->application, TRUE);
					} else {
						$view .= $this->view("download", $vars, $this->application, TRUE);
					}
					$i++;
				} 
			}

			$view .= '</div>';

			$this->setPDF($view, $patientData["Name"] .'.pdf');
		}
	}
	
	public function get($IDPatient = FALSE) {
		$this->Patients_Model = $this->model("Patients_Model");
		
		$start = 0;

		$this->CSS("pagination");

		if(segment(1, isLang()) === "page" and segment(2, isLang()) > 0) {
			$start = (segment(2, isLang()) * 25) - 25;
		}
		
		$limit = $start .", 25";	
		$count = $this->Test_Model->count($IDPatient);
		$URL   = path("patients/page/");

		$pagination = ($count > 25) ? paginate($count, 25, $start, $URL) : NULL;

		$formats = $this->Test_Model->getByIDPatient($IDPatient, $limit);
		$patient = $this->Patients_Model->getPatient($IDPatient);
		
		$fIDs = "";
		$i = 0;
		$total = count($formats) - 1;

		if(is_array($formats)) {
			foreach($formats as $format) {
				$fIDs .= ($i === $total) ? $format["ID_Format"] : $format["ID_Format"] .",";

				$i++;
			}
		}

		$vars["fIDs"]       = $fIDs;
		$vars["pagination"] = $pagination;
		$vars["formats"]    = $formats;
		$vars["patient"]    = $patient;
		$vars["view"] 	    = $this->view("tests", TRUE, "test");

		$this->render("content", $vars);	
	}
}
