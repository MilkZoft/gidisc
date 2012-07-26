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
			$data["Start"]  = 1;
		} elseif($age == 5) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 10", $this->table);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 10", $this->table, NULL, "ID_Word DESC");
			$data["Start"]  = 10;
		} elseif($age == 6) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 26", $this->table);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 26", $this->table, NULL, "ID_Word DESC");
			$data["Start"]  = 26;
		} elseif($age == 7) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 38", $this->table);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 38", $this->table, NULL, "ID_Word DESC");
			$data["Start"]  = 38;
		} elseif($age == 8) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 50", $this->table);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 50", $this->table, NULL, "ID_Word DESC");
			$data["Start"]  = 50;
		} elseif($age == 9) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 60", $this->table);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 60", $this->table, NULL, "ID_Word DESC");
			$data["Start"]  = 60;
		} elseif($age == 10) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 70", $this->table);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 70", $this->table, NULL, "ID_Word DESC");
			$data["Start"]  = 70;
		} elseif($age == 11) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 77", $this->table);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 77", $this->table, NULL, "ID_Word DESC");
			$data["Start"]  = 77;
		} elseif($age == 12) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 82", $this->table);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 82", $this->table, NULL, "ID_Word DESC");
			$data["Start"]  = 82;
		} elseif($age == 13) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 86", $this->table);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 86", $this->table, NULL, "ID_Word DESC");
			$data["Start"]  = 86;
		} elseif($age == 14) {
			$data["Words1"] = $this->Db->findBySQL("ID_Word >= 90", $this->table);
			$data["Words2"] = $this->Db->findBySQL("ID_Word < 90", $this->table, NULL, "ID_Word DESC");
			$data["Start"]  = 90;
		}

		return $data;
	}

	public function setTemporal($data) {
		$data = json_encode($data);

		if(!$this->Db->findBy("ID_User", SESSION("ZanUserID"), "peabody_temp")) {
			$this->Db->insert("peabody_temp", array("ID_User" => SESSION("ZanUserID"), "Content" => $data));

			return TRUE;
		}

		return FALSE;
	}

	public function getTemporal() {
		$data = $this->Db->findBy("ID_User", SESSION("ZanUserID"), "peabody_temp");
		
		return json_decode($data[0]["Content"]);
	}
}
