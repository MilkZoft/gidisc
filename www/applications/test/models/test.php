<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class Test_Model extends ZP_Model {
	
	public function __construct() {
		$this->Db = $this->db();
		
		$this->helper(array("time", "alerts", "router"));
		
		$this->table    = "areas";
		$this->language = whichLanguage(); 

		$this->Data = $this->core("Data");

		$this->Data->table($this->table);
	}
	
	public function getArea($id) {
		$area   = $this->Db->find($id, $this->table);
		$parent = $this->Db->find($area[0]["ID_Parent"], $this->table);
		
		$data = $area[0];
		
		$data["Parent1"]["ID_Area"] = $parent[0]["ID_Area"];
		$data["Parent1"]["Name"]    = $parent[0]["Name"];
		
		$data["Parent2"]["ID_Area"] = FALSE;
		$data["Parent2"]["Name"]    = FALSE;
		
		if($parent[0]["ID_Parent"] !== FALSE) {
			$parent2 = $this->Db->find($parent[0]["ID_Parent"], $this->table);
			
			$data["Parent2"]["ID_Area"] = $parent2[0]["ID_Area"];
			$data["Parent2"]["Name"]    = $parent2[0]["Name"];
		}
		
		return $data;
	}
	
	public function getObjectives($ID) {
		return $this->Db->findBy("ID_Area", $ID, "objectives");
	}
	
	public function getLastAreas() {
		$data = $this->Db->findBy("Monitoring", "1", $this->table, NULL, "ID_Parent");
	
		foreach($data as $key => $value) {
			$record = $this->Db->find($value["ID_Parent"], $this->table);
			$data[$key]["Parent"] = $record[0]["Name"];
		}
		
		return $data;
	}
	
	public function delete($IDFormat) {
		return $this->Db->delete($IDFormat, "formats");
	}
	
	public function edit($IDFormat) {
		$objectives = POST("objective");
		$days       = POST("days");
		$obsv       = POST("obsv");
		
		$data = array( 
			"ID_Therapist" => POST("terapist"),
			"ID_Area"      => POST("area"),
			"Month_"       => POST("month"),
			"Comments"     => POST("comments"),
			"Work_Home"    => POST("work")
		);
		
		$insert = $this->Db->update("formats", $data, $IDFormat);
		
		$delete = $this->Db->deleteBy("ID_Format", $IDFormat, NULL, "objectives_particular");
		
		foreach($objectives as $key => $objective) {
			$data = array( 
				"ID_Format"  => $IDFormat,
				"Objetive"   => $objective,
				"Comments"   => $obsv[$key],
				"Date_Entry" => now(4)	
			);
			
			$IDObjective = $this->Db->insert("objectives_particular", $data);
			
			foreach($days as $key2 => $day) {
				$data = array( 
					"ID_Objetive" => $IDObjective,
					"Day_"        => (string) $key2 + 1,
					"Rating"      => (string) $day[$key]
				);
				
				$answer = $this->Db->insert("objectives_answer", $data);
			}
		}
		
		return getAlert("The test has been edited correctly", "success");
	}
	
	public function save() {
		if(POST("area") < 32) {
			$objectives = POST("objective");
			$days       = POST("days");
			$day        = POST("day");
			$obsv       = POST("obsv");
						
			$data = array( 
				"ID_Therapist" => POST("terapist"),
				"ID_User"      => POST("IDPatient"),
				"ID_Area"      => POST("area"),
				"Month_"       => POST("month"),
				"Year"		   => POST("year"),
				"Comments"     => POST("comments"),
				"Work_Home"    => POST("work"),
				"Date_Entry"   => now(4),
				"Text_Date"    => now(2)
			);
			
			$insert = $this->Db->insert("formats", $data);
			
			foreach($objectives as $key => $objective) {
				$data = array( 
					"ID_Format"  => $insert,
					"Objetive"   => $objective,
					"Comments"   => $obsv[$key],
					"Date_Entry" => now(4)	
				);
				
				$IDObjective = $this->Db->insert("objectives_particular", $data);
				
				foreach($days as $key2 => $value) {
					$data = array( 
						"ID_Objetive" => $IDObjective,
						"Day_"        => $day[$key2],
						"Rating"      => $value[$key]
					);
					
					$answer = $this->Db->insert("objectives_answer", $data);
				}
			}
		} else {
			$data = array( 
				"ID_Therapist" => POST("terapist"),
				"ID_User"      => POST("IDPatient"),
				"ID_Area"      => POST("area"),
				"Comments"     => POST("comments"),
				"Date_Entry"   => now(4),
				"Text_Date"    => now(2)
			);
			
			$insert = $this->Db->insert("formats", $data);
		}
		
		return getAlert("The test has been saved correctly", "success");
	}
	
	public function all($limit = 25) {
		$query = "SELECT * FROM zan_formats 
				LEFT JOIN zan_users ON zan_users.ID_User = zan_re_user_person.ID_User 
				WHERE zan_users.Situation != 'Deleted' ORDER BY ID_Format DESC LIMIT {$limit}";
		
		$data = $this->Db->query($query);
		
		return $data;
	}
	
	public function count($IDPatient) {
		$query = "SELECT count(*) as count FROM zan_formats 
				LEFT JOIN zan_areas ON zan_areas.ID_Area = zan_formats.ID_Area 
				WHERE zan_formats.ID_User = {$IDPatient}";
		$data  = $this->Db->query($query);
		
		return $data[0]["count"];
	}
	
	/*Formats*/
	public function getByIDPatient($IDPatient, $limit = 25) {
		$query = "SELECT * FROM zan_formats 
				LEFT JOIN zan_areas ON zan_areas.ID_Area = zan_formats.ID_Area 
				WHERE zan_formats.ID_User = {$IDPatient} ORDER BY ID_Format DESC LIMIT {$limit}";

		$data  = $this->Db->query($query);
		
		return $data;
	}

	public function getFormat($patientID, $areaID) {
		$query = "SELECT * FROM zan_formats 
				LEFT JOIN zan_areas ON zan_areas.ID_Area = zan_formats.ID_Area 
				WHERE zan_formats.ID_User = '$patientID' AND zan_formats.ID_Area = '$areaID' ORDER BY ID_Format DESC LIMIT 1";

		$formats = $this->Db->query($query);
		$i = 0;

		if(count($formats) === 1) {				
			$objectives = $this->Db->findBy("ID_Format", $formats[0]["ID_Format"], "objectives_particular");
			
			if(!$objectives) {
				$data[$i]["answers"] = FALSE;
			} else {
				foreach($objectives as $key => $objective) {
					$data[$i]["answers"][$key] = $this->Db->findBy("ID_Objetive", $objective["ID_Objetive"], "objectives_answer");
				}
			}
			
			$data[$i]["format"]     = $formats[0];
			$data[$i]["objectives"] = $objectives;
			
			#return $data;
		} else {
			foreach($formats as $format) {
				$objectives = $this->Db->findBy("ID_Format", $format["ID_Format"], "objectives_particular");
				
				if(!$objectives) {
					$data[$i]["answers"] = FALSE;
				} else {
					foreach($objectives as $key => $objective) {
						$data[$i]["answers"][$key] = $this->Db->findBy("ID_Objetive", $objective["ID_Objetive"], "objectives_answer");
					}
				}		
				
				$data[$i]["format"]     = $format;
				$data[$i]["objectives"] = $objectives;
				$i++;
			}
		}

		return isset($data) ? $data : FALSE;
	}
	
	public function get($IDFormat) {
		$query = "SELECT * FROM zan_formats 
				LEFT JOIN zan_areas ON zan_areas.ID_Area = zan_formats.ID_Area 
				WHERE zan_formats.ID_Format IN ($IDFormat)";

		$formats = $this->Db->query($query);
		$i = 0;

		if(count($formats) === 1) {				
			$objectives = $this->Db->findBy("ID_Format", $IDFormat, "objectives_particular");
			
			if(!$objectives) {
				$data[$i]["answers"] = FALSE;
			} else {
				foreach($objectives as $key => $objective) {
					$data[$i]["answers"][$key] = $this->Db->findBy("ID_Objetive", $objective["ID_Objetive"], "objectives_answer");
				}
			}
			
			$data[$i]["format"]     = $formats[0];
			$data[$i]["objectives"] = $objectives;
			
			#return $data;
		} else {
			foreach($formats as $format) {
				$objectives = $this->Db->findBy("ID_Format", $format["ID_Format"], "objectives_particular");
				
				if(!$objectives) {
					$data[$i]["answers"] = FALSE;
				} else {
					foreach($objectives as $key => $objective) {
						$data[$i]["answers"][$key] = $this->Db->findBy("ID_Objetive", $objective["ID_Objetive"], "objectives_answer");
					}
				}		
				
				$data[$i]["format"]     = $format;
				$data[$i]["objectives"] = $objectives;
				$i++;
			}
		}

		return isset($data) ? $data : FALSE;
	}
}
