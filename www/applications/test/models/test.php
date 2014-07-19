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

	public function editTest() {
		if(POST("action") === "Update") { 
			if(POST("area") < 32) {
				$results    = array();
				$objectives = array_values(array_diff(POST("objective"), array('')));
				$values     = $this->getResults(POST("days"));
				$days 		= array_values(array_diff(POST("day"), array('')));
				$obsv		= POST("obsv");
				$formatID	= POST("ID_Format");
				$count = count($objectives) - 1;
				
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

				$update = $this->Db->update("formats", $data, $formatID);

				$this->Db->deleteBySQL("ID_Format = '$formatID'", "objectives_particular");
						
				for($o = 0; $o <= $count; $o++) {
					$data = array( 
						"ID_Format"  => $formatID,
						"Objetive"   => $objectives[$o],
						"Comments"   => isset($obsv[$o]) ? $obsv[$o] : NULL,
						"Date_Entry" => now(4)	
					);
									
					$IDObjective = $this->Db->insert("objectives_particular", $data);
					$this->Db->deleteBySQL("ID_Format = '$formatID'", "objectives_answer");

					for($d = 0; $d <= count($values[$o]) - 1; $d++) {
						$data2[] = array( 
							"ID_Format"   => $formatID,
							"ID_Objetive" => $IDObjective,
							"Day_"        => isset($days[$d]) ? $days[$d] : 0,
							"Rating"      => $values[$o][$d] 
						);
					}
				}

				$this->Db->insertBatch("objectives_answer", $data2);
			} else {
				$data = array( 
					"ID_Therapist" => POST("terapist"),
					"ID_User"      => POST("IDPatient"),
					"ID_Area"      => POST("area"),
					"Comments"     => POST("comments"),
					"Date_Entry"   => now(4),
					"Text_Date"    => now(2)
				);
					
				$this->Db->update("formats", $data, POST("ID_Format"));
			}

			showAlert("El formato fue actualizado con éxito", path("patients"));
		} else {
			if(POST("area") < 32) {
				$results    = array();
				$objectives = array_values(array_diff(POST("objective"), array('')));
				$values     = $this->getResults(POST("days"));
				$days 		= array_values(array_diff(POST("day"), array('')));
				$obsv		= POST("obsv");
				$formatID	= POST("ID_Format");
				$count = count($objectives) - 1;
				
				$data = array( 
					"ID_Therapist" => POST("terapist"),
					"ID_User"      => POST("IDPatient"),
					"ID_Area"      => POST("area"),
					"Month_"       => POST("month"),
					"Year"		   	 => POST("year"),
					"Comments"     => POST("comments"),
					"Work_Home"    => POST("work"),
					"Date_Entry"   => now(4),
					"Text_Date"    => now(2)
				);
				
				$formatID = $this->Db->insert("formats", $data);
				
				for($o = 0; $o <= $count; $o++) {
					$data = array( 
						"ID_Format"  => $formatID,
						"Objetive"   => $objectives[$o],
						"Comments"   => isset($obsv[$o]) ? $obsv[$o] : NULL,
						"Date_Entry" => now(4)	
					);
									
					$IDObjective = $this->Db->insert("objectives_particular", $data);

					for($d = 0; $d <= count($values[$o]) - 1; $d++) {
						$data2[] = array( 
							"ID_Format"   => $formatID,
							"ID_Objetive" => $IDObjective,
							"Day_"        => isset($days[$d]) ? $days[$d] : '',
							"Rating"      => $values[$o][$d] 
						);
					}
				}

				if (isset($data2) and is_array($data2)) {
					$this->Db->insertBatch("objectives_answer", $data2);
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

			showAlert("Nuevo formato guardado con éxito", path("patients"));
		}
	}
	
	public function save() {
		if(POST("area") < 32) {
			$objectives = array_values(array_diff(POST("objective"), array('')));
			$values     = $this->getResults(POST("days"));
			$days 		= array_values(array_diff(POST("day"), array('')));
			$obsv		= POST("obsv");
			$formatID	= POST("ID_Format");
			$results    = array();
			$count = count($objectives) - 1;

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
			
			$formatID = $this->Db->insert("formats", $data);
				
			for($o = 0; $o <= $count; $o++) {
				$data = array( 
					"ID_Format"  => $formatID,
					"Objetive"   => $objectives[$o],
					"Comments"   => isset($obsv[$o]) ? $obsv[$o] : NULL,
					"Date_Entry" => now(4)	
				);
								
				$IDObjective = $this->Db->insert("objectives_particular", $data);

				for($d = 0; $d <= count($values[$o]) - 1; $d++) {
					$data2[] = array( 
						"ID_Format"   => $formatID,
						"ID_Objetive" => $IDObjective,
						"Day_"        => isset($days[$d]) ? $days[$d] : '',
						"Rating"      => is_numeric($values[$o][$d]) ? (int) $values[$o][$d] : $values[$o][$d]
					);
				}
			}

			$this->Db->insertBatch("objectives_answer", $data2);
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
		
		showAlert("Nuevo formato guardado con éxito", path("patients"));
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

	public function getResults($values) {
		$results = array();

		for ($i = 0; $i <= 14; $i++) {
			if (isset($values[$i][0]) and is_numeric($values[$i][0])) 
				$results[0][$i]  = ((int) $values[$i][0]  == 0) ? '$' : $values[$i][0];
			else
				$results[0][$i]  = isset($values[$i][0]) ? $values[$i][0] : '';

			if (isset($values[$i][1]) and is_numeric($values[$i][1])) 
				$results[1][$i]  = ((int) $values[$i][1]  == 0) ? '$' : $values[$i][1];
			else
				$results[1][$i]  = isset($values[$i][1]) ? $values[$i][1] : '';

			if (isset($values[$i][2]) and is_numeric($values[$i][2])) 
				$results[2][$i]  = ((int) $values[$i][2]  == 0) ? '$' : $values[$i][2];
			else	
				$results[2][$i]  = isset($values[$i][2]) ? $values[$i][2] : '';

			if (isset($values[$i][3]) and is_numeric($values[$i][3])) 
				$results[3][$i]  = ((int) $values[$i][3]  == 0) ? '$' : $values[$i][3];
			else
				$results[3][$i]  = isset($values[$i][3]) ? $values[$i][3] : '';
				
			if (isset($values[$i][4]) and is_numeric($values[$i][4])) 
				$results[4][$i]  = ((int) $values[$i][4]  == 0) ? '$' : $values[$i][4];
			else
				$results[4][$i]  = isset($values[$i][4]) ? $values[$i][4] : '';

			if (isset($values[$i][5]) and is_numeric($values[$i][5])) 
				$results[5][$i]  = ((int) $values[$i][5]  == 0) ? '$' : $values[$i][5];
			else
				$results[5][$i]  = isset($values[$i][5]) ? $values[$i][5] : '';

			if (isset($values[$i][6]) and is_numeric($values[$i][6])) 
				$results[6][$i]  = ((int) $values[$i][6]  == 0) ? '$' : $values[$i][6];
			else
				$results[6][$i]  = isset($values[$i][6]) ? $values[$i][6] : '';

			if (isset($values[$i][7]) and is_numeric($values[$i][7])) 
				$results[7][$i]  = ((int) $values[$i][7]  == 0) ? '$' : $values[$i][7];
			else
				$results[7][$i]  = isset($values[$i][7]) ? $values[$i][7] : '';

			if (isset($values[$i][8]) and is_numeric($values[$i][8])) 
				$results[8][$i]  = ((int) $values[$i][8]  == 0) ? '$' : $values[$i][8];
			else
				$results[8][$i]  = isset($values[$i][8]) ? $values[$i][8] : '';

			if (isset($values[$i][9]) and is_numeric($values[$i][9])) 
				$results[9][$i]  = ((int) $values[$i][9]  == 0) ? '$' : $values[$i][9];
			else
				$results[9][$i]  = isset($values[$i][9]) ? $values[$i][9] : '';

			if (isset($values[$i][10]) and is_numeric($values[$i][10])) 
				$results[10][$i] = ((int) $values[$i][10] == 0) ? '$' : $values[$i][10];
			else
				$results[10][$i]  = isset($values[$i][10]) ? $values[$i][10] : '';

			if (isset($values[$i][11]) and is_numeric($values[$i][11])) 
				$results[11][$i] = ((int) $values[$i][11] == 0) ? '$' : $values[$i][11];
			else
				$results[11][$i]  = isset($values[$i][11]) ? $values[$i][11] : '';

			if (isset($values[$i][12]) and is_numeric($values[$i][12])) 
				$results[12][$i] = ((int) $values[$i][12] == 0) ? '$' : $values[$i][12];
			else
				$results[12][$i]  = isset($values[$i][12]) ? $values[$i][12] : '';

			if (isset($values[$i][13]) and is_numeric($values[$i][13])) 
				$results[13][$i] = ((int) $values[$i][13] == 0) ? '$' : $values[$i][13];
			else
				$results[13][$i]  = isset($values[$i][13]) ? $values[$i][13] : '';

			if (isset($values[$i][14]) and is_numeric($values[$i][14])) 
				$results[14][$i] = ((int) $values[$i][14] == 0) ? '$' : $values[$i][14];
			else
				$results[14][$i]  = isset($values[$i][14]) ? $values[$i][14] : '';
		}

		return $results;
	}
}
