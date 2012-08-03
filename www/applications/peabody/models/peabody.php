<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class Peabody_Model extends ZP_Model {
	
	public function __construct() {
		$this->Db = $this->db();
		
		$this->helper(array("time", "alerts", "router"));
		
		$this->table    = "peabody_words";
		$this->language = whichLanguage(); 

		$this->Data = $this->core("Data");

		$this->Data->table($this->table);
	}

	public function getBlocks($words) {
		if($words["Words1"]) {
			$i = 1;
			$j = 1;

			foreach($words["Words1"] as $word) {
				if(is_array($word)) {
					$data["Words1"]["$j"][$i] = $word;

					if($i == 8) { 
						$i = 1; 
						$j++;
					} else {
						$i++;
					}
				}
			}
		} else {
			$data["Words1"] = FALSE;
		}

		if($words["Words2"]) {
			$i = 1;
			$j = 1;

			foreach($words["Words2"] as $word) {
				if(is_array($word)) {
					$data["Words2"]["$j"][$i] = $word;

					if($i == 8) { 
						$i = 1; 
						$j++;
					} else {
						$i++;
					}
				}	
			}
		} else {
			$data["Words2"] = FALSE;
		}

		return $data;
	}

	public function setResult($score) {
		$data = $this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."'", "peabody_results", NULL, "ID_Result DESC", 1);
		
		if($data) {
			$attempt = (int) $data[0]["Attempt"] + 1;
		} else {
			$attempt = 1;
		}

		$this->Db->insert("peabody_results", array("ID_User" => SESSION("ZanUserID"), "Result" => $score, "Start_Date" => now(4), "Attempt" => $attempt));

		$this->Db->deleteBySQL("ID_User = '". SESSION("ZanUserID") ."'", "peabody_temp");

		unset($_SESSION["Last"]);
		unset($_SESSION["Corrects"]);
		unset($_SESSION["Error"]);
		unset($_SESSION["Success"]);
		unset($_SESSION["Start"]);
		unset($_SESSION["First"]);
		unset($_SESSION["LastError"]);

		return TRUE;
	}

	public function getScore($corrects) {
		$data = $this->Db->findBy("Score", $corrects, "peabody_scores");

		return ($data) ? $data[0]["Age"] : FALSE;
	}

	public function setCorrections($age = NULL) {
		$this->Db->updateBySQL("peabody_temp", "Correction = '1' WHERE ID_User = '" . SESSION("ZanUserID") ."' AND Correct = '1' AND Block = '1' AND Age = '$age'");
	
		return TRUE;
	}

	public function getCorrections($block = NULL, $age = NULL) {
		if($block === TRUE and $age === TRUE) {
			$data = $this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."' AND Correct = 1 AND Correction = 1", "peabody_temp", NULL, "ID_Word ASC", 1);

			$return["low"] = ($data) ? $data[0]["ID_Word"] : 0;

			$data = $this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."' AND Correct = 1 AND Correction = 1", "peabody_temp");

			$return["data"] = ($data) ? $data : 0;

			return $return;
		} elseif($block === TRUE) {
			return $this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."' AND Correct = 1 AND Correction = 1", "peabody_temp");	
		} 

		return $this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."' AND Block = '$block' AND Age = '$age' AND Correct = 1", "peabody_temp");
	}

	public function getCorrects($block = NULL, $age = NULL, $all = FALSE) {
		if($block === TRUE and $age === TRUE) {
			if(!$all) {
				$data = $this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."' AND Correct = 1 AND Correction = 0", "peabody_temp", NULL, "ID_Word ASC", 1);
			} else {
				$data = $this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."' AND Correct = 1", "peabody_temp", NULL, "ID_Word ASC", 1);
			}

			$return["low"] = ($data) ? $data[0]["ID_Word"] : 0;

			if(!$all) {
				$data = $this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."' AND Correct = 1 AND Correction = 0", "peabody_temp");
			} else {
				$data = $this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."' AND Correct = 1", "peabody_temp");
			}

			$return["data"] = ($data) ? $data : 0;

			return $return;
		} elseif($block === TRUE) {
			if(!$all) {
				return $this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."' AND Correct = 1 AND Correction = 0", "peabody_temp");
			} else {
				return $this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."' AND Correct = 1", "peabody_temp");
			}
		} 

		return $this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."' AND Block = '$block' AND Age = '$age' AND Correct = 1", "peabody_temp");
	}

	public function getIncorrects($block, $age) {
		return $this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."' AND Block = '$block' AND Age = '$age' AND Correct = 0", "peabody_temp");
	}

	public function setWord($data) {
		$this->Db->insert("peabody_temp", $data);

		return TRUE;
	}

	public function getWord($ID_Word) {
		return $this->Db->find($ID_Word, $this->table);
	}
	
	public function getWords($age, $limit = NULL) {
		if($age == 3 or $age == 4) {
			$data["Words1"] = $this->Db->findAll($this->table, NULL, "ID_Word ASC", $limit);
			$data["Words2"] = FALSE;
			$data["Start"]  = 1;
		} elseif($age == 5) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 10", $this->table, NULL, "ID_Word ASC", $limit);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 10", $this->table, NULL, "ID_Word DESC", $limit);
			$data["Start"]  = 10;
		} elseif($age == 6) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 26", $this->table, NULL, "ID_Word ASC", $limit);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 26", $this->table, NULL, "ID_Word DESC", $limit);
			$data["Start"]  = 26;
		} elseif($age == 7) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 38", $this->table, NULL, "ID_Word ASC", $limit);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 38", $this->table, NULL, "ID_Word DESC", $limit);
			$data["Start"]  = 38;
		} elseif($age == 8) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 50", $this->table, NULL, "ID_Word ASC", $limit);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 50", $this->table, NULL, "ID_Word DESC", $limit);
			$data["Start"]  = 50;
		} elseif($age == 9) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 60", $this->table, NULL, "ID_Word ASC", $limit);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 60", $this->table, NULL, "ID_Word DESC", $limit);
			$data["Start"]  = 60;
		} elseif($age == 10) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 70", $this->table, NULL, "ID_Word ASC", $limit);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 70", $this->table, NULL, "ID_Word DESC", $limit);
			$data["Start"]  = 70;
		} elseif($age == 11) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 77", $this->table, NULL, "ID_Word ASC", $limit);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 77", $this->table, NULL, "ID_Word DESC", $limit);
			$data["Start"]  = 77;
		} elseif($age == 12) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 82", $this->table, NULL, "ID_Word ASC", $limit);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 82", $this->table, NULL, "ID_Word DESC", $limit);
			$data["Start"]  = 82;
		} elseif($age == 13) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 86", $this->table, NULL, "ID_Word ASC", $limit);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 86", $this->table, NULL, "ID_Word DESC", $limit);
			$data["Start"]  = 86;
		} elseif($age == 14) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 90", $this->table, NULL, "ID_Word ASC", $limit);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 90", $this->table, NULL, "ID_Word DESC", $limit);
			$data["Start"]  = 90;
		}

		return $data;
	}

	public function updateTemporal($data, $answers = 0) {
		$data = json_encode($data);

		if($this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."' AND Answers = '$answers'", "peabody_temp")) {
			$this->Db->updateBySQL("peabody_temp", "Answers = '$answers', Content = '$data' WHERE ID_User = '". SESSION("ZanUserID") ."' AND Answers = '1'");

			return TRUE;
		} else {
			$this->setTemporal($data, $answers);
		}

		return FALSE;
	}

	public function setTemporal($data, $answers = 0) {
		$data = json_encode($data);

		if(substr($data, 0, 1) == '"') {
			$data = substr($data, 1, strlen($data) - 2);
		}

		if(!$this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."' AND Answers = '$answers'", "peabody_temp")) {
			$this->Db->insert("peabody_temp", array("ID_User" => SESSION("ZanUserID"), "Answers" => $answers, "Content" => $data));

			return TRUE;
		}

		return FALSE;
	}

	public function getTemporal($answers = 0) {
		$data = $this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."' AND Answers = '$answers'", "peabody_temp");

		return ($data) ? json_decode($data[0]["Content"], TRUE) : array();
	}
}
