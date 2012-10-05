<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class D2_Model extends ZP_Model {
	
	public function __construct() {
		$this->Db = $this->db();
		
		$this->helper(array("time", "alerts", "router"));
		
		$this->table    = "bta";
		$this->language = whichLanguage(); 

		$this->Data = $this->core("Data");

		$this->Data->table($this->table);
	}

	public function setResult($corrects, $age) {
		if($corrects <= 7) {
			$percentil = "<2";
		} elseif($corrects === 8) {
			if($age < 65) {
				$percentil = "<2";
			} else {
				$percentil = "2-9";
			}
		} elseif($corrects === 9) {
			if($age < 55) {
				$percentil = "<2";
			} elseif($age < 75) {
				$percentil = "2-9";
			} else {
				$percentil = "10-24";
			}
		} elseif($corrects === 10) {
			if($age < 40) {
				$percentil = "<2";
			} elseif($age < 65) {
				$percentil = "2-9";
			} else {
				$percentil = "10-24";
			}
		} elseif($corrects === 11) {
			if($age < 30) {
				$percentil = "<2";
			} elseif($age < 55) {
				$percentil = "2-9";
			} else {
				$percentil = "10-24";
			}
		} elseif($corrects === 12) {
			if($age < 40) {
				$percentil = "2-9";
			} elseif($age < 65) {
				$percentil = "10-24";
			} else {
				$percentil = "25-74";
			}
		} elseif($corrects === 13) {
			if($age < 30) {
				$percentil = "2-9";
			} elseif($age < 65) {
				$percentil = "10-24";
			} else {
				$percentil = "25-74";
			}
		} elseif($corrects === 14) {
			if($age < 60) {
				$percentil = "10-24";
			} else {
				$percentil = "25-74";
			}
		} elseif($corrects === 15) {
			if($age < 35) {
				$percentil = "10-24";
			} else {
				$percentil = "25-74";
			}
		} elseif($corrects === 16) {
			$percentil = "25-74";
		} elseif($corrects === 17) {
			if($age < 75) {
				$percentil = "25-74";
			} else {
				$percentil = ">74";
			}
		} elseif($corrects === 18) {
			if($age < 70) {
				$percentil = "25-74";
			} else {
				$percentil = ">74";
			}
		} elseif($corrects === 19) {
			if($age < 60) {
				$percentil = "25-74";
			} else {
				$percentil = ">74";
			}
		} else {
			$percentil = ">74";
		}

		$data = array(
			"ID_User" 	=> SESSION("ZanUserID"),
			"Age" 		=> $age,
			"Percentil" => $percentil
		);

		$this->Db->insert($this->table, $data);

		unset($_SESSION["btaCorrects"]);
		unset($_SESSION["btaLComplete"]);
		unset($_SESSION["btaNComplete"]);

		return $percentil;
	}
}
