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
	
	public function getWords($age) {
		if($age == 3 or $age == 4) {
			$data["Words1"] = $this->Db->findAll($this->table);
			$data["Words2"] = FALSE;
		} elseif($age == 5) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 10", $this->table);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 10", $this->table, NULL, "ID_Word DESC");
		} elseif($age == 6) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 26", $this->table);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 26", $this->table, NULL, "ID_Word DESC");
		} elseif($age == 7) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 38", $this->table);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 38", $this->table, NULL, "ID_Word DESC");
		} elseif($age == 8) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 50", $this->table);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 50", $this->table, NULL, "ID_Word DESC");
		} elseif($age == 9) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 60", $this->table);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 60", $this->table, NULL, "ID_Word DESC");
		} elseif($age == 10) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 70", $this->table);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 70", $this->table, NULL, "ID_Word DESC");
		} elseif($age == 11) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 77", $this->table);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 77", $this->table, NULL, "ID_Word DESC");
		} elseif($age == 12) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 82", $this->table);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 82", $this->table, NULL, "ID_Word DESC");
		} elseif($age == 13) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 86", $this->table);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 86", $this->table, NULL, "ID_Word DESC");
		} elseif($age == 14) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 90", $this->table);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 90", $this->table, NULL, "ID_Word DESC");
		}

		return $data;
	}
}
