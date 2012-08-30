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

	public function getTotalFirstBlock() {
		$total = $this->Db->findBySQL("Correct = 0 AND FirstBlock = 1", "peabody_answers");
		
		if($total) {
			if(count($total) == 1) {
				return 0;
			} else {
				return count($total);
			}
		} else {
			return 0;
		}

		return ($total) ? count($total) : 0;
	}

	public function resetAnswers() {
		$this->Db->updateBySQL("peabody_answers", "FirstBlock = 0 WHERE FirstBlock = 1");
	}

	public function findBlock($number, $force = FALSE) {
		if($force) {
			$data = $this->Db->findBySQL("Limit1 <= '$number'", "peabody_blocks", NULL, "ID_Block DESC", 1);

			return $data[0]["ID_Block"];
		} elseif(!SESSION("Block") and !SESSION("FirstBlockComplete")) {
			$data = $this->Db->findBySQL("Limit1 <= '$number'", "peabody_blocks", NULL, "ID_Block DESC", 5);

			SESSION("Block", $data[0]["ID_Block"]);

			return $data;			
		} elseif(SESSION("Block") and !SESSION("FirstBlockComplete")) {
			return SESSION("Block");
		}
	}

	public function findAnswer($user, $block, $word, $correct, $firstBlock = 0) {
		$data = $this->Db->findBySQL("ID_User = '$user' AND ID_Block = '$block' AND ID_Word = '$word' AND Correct = '$correct' AND FirstBlock = '$firstBlock'", "peabody_answers");

		return $data;
	}

	public function setAnswer($user, $block, $word, $correct, $firstBlock = 0) {
		if($firstBlock == 1 and $correct == 0) {
			$_SESSION["LastBlockError"][0] = $block;		
		}
		
		$data = array(
			"ID_User" 	 => $user,
			"ID_Block" 	 => $block,
			"ID_Word"	 => $word,
			"Correct"	 => $correct,
			"FirstBlock" => $firstBlock
		);

		return $this->Db->insert("peabody_answers", $data);
	}

	public function getAnswers($block, $firstBlock = FALSE) {
		if(!$firstBlock) {
			$total["total"] = $this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."' AND ID_Block = '$block'", "peabody_answers");
		
			$total["total"] = (!$total["total"]) ? 0 : count($total["total"]);

			if($total["total"] > 0) {
				$total["corrects"] = $this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."' AND ID_Block = '$block' AND Correct = 1", "peabody_answers");

				$total["corrects"] = (!$total["corrects"]) ? 0 : count($total["corrects"]);

				$total["incorrects"] = $this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."' AND ID_Block = '$block' AND Correct = 0", "peabody_answers");

				$total["incorrects"] = (!$total["incorrects"]) ? 0 : count($total["incorrects"]);

				return $total;
			}
		} else {
			$total["total"] = $this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."' AND ID_Block = '$block'  AND FirstBlock = 1", "peabody_answers");

			$total["total"] = (!$total["total"]) ? 0 : count($total["total"]);

			if($total["total"] > 0) {
				$total["corrects"] = $this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."' AND ID_Block = '$block' AND Correct = 1 AND FirstBlock = 1", "peabody_answers");

				$total["corrects"] = (!$total["corrects"]) ? 0 : count($total["corrects"]);

				$total["incorrects"] = $this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."' AND ID_Block = '$block' AND Correct = 0 AND FirstBlock = 1", "peabody_answers");

				$total["incorrects"] = (!$total["incorrects"]) ? 0 : count($total["incorrects"]);

				return $total;
			}
		}

		return FALSE;
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

	public function setResult($score, $corrects) {
		$data = $this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."'", "peabody_results", NULL, "ID_Result DESC", 1);
		
		if($data) {
			$attempt = (int) $data[0]["Attempt"] + 1;
		} else {
			$attempt = 1;
		}

		$this->Db->insert("peabody_results", array("ID_User" => SESSION("ZanUserID"), "Result" => $score, "Corrects" => $corrects, "Start_Date" => now(4), "Attempt" => $attempt));

		$this->Db->deleteBySQL("ID_User = '". SESSION("ZanUserID") ."'", "peabody_answers");

		unset($_SESSION["Last"]);
		unset($_SESSION["Error"]);
		unset($_SESSION["Start"]);
		unset($_SESSION["First"]);
		unset($_SESSION["LastError"]);
		unset($_SESSION["FirstBlockComplete"]);
		unset($_SESSION["Block"]);
		unset($_SESSION["LastBlockError"]);

		return TRUE;
	}

	public function getScore($corrects) {
		$data = $this->Db->findBy("Score", $corrects, "peabody_scores");

		return ($data) ? $data[0]["Age"] : FALSE;
	}


	public function getCorrects($block = NULL, $age = NULL) {
		if($block === TRUE and $age === TRUE) {			
			$data = $this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."' AND Correct = 0 GROUP BY ID_Word", "peabody_answers", NULL, "ID_Word DESC", 1);
			
			$last = $data[0]["ID_Word"];

			$data = $this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."' AND Correct = 0 GROUP BY ID_Word", "peabody_answers");

			$errors = count($data);

			return ($last - $errors);
		} 
	}

	public function getIncorrects($block, $age) {
		return $this->Db->findBySQL("ID_User = '". SESSION("ZanUserID") ."' AND Block = '$block' AND Age = '$age' AND Correct = 0", "peabody_temp");
	}

	public function setWord($data) {
		$this->Db->insert("peabody_temp", $data);

		return TRUE;
	}

	public function setBlock($data) {
		$this->Db->insert("peabody_blocks", $data);

		return TRUE;	
	}

	public function getWord($ID_Word) {
		return $this->Db->find($ID_Word, $this->table);
	}
	
	public function getBlockDetails($block) {
		$total["errors"] = $this->Db->findBySQL("Block = '$block' AND Correct = 0", "peabody_blocks");
		$total["total"]  = $this->Db->findBySQL("Block = '$block'", "peabody_blocks");

		return $total;
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
