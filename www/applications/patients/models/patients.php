<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class Patients_Model extends ZP_Model {
	
	public function __construct() {
		$this->Db = $this->db();
		
		$this->helper(array("time", "alerts", "router"));
		
		$this->table    = "patients";
		$this->language = whichLanguage(); 

		$this->Data = $this->core("Data");

		$this->Data->table($this->table);
	}

	public function assignCenters($type) {
		$centers = POST("centers");
		$ID_Patient = POST("ID_Patient");
	
		$this->Db->deleteBySQL("ID_User = '$ID_Patient'", "re_users_centers");

		if($centers) {
			for($i = 0; $i <= count($centers) - 1; $i++) {
				$data = array(
					"ID_Center" => $centers[$i],
					"ID_User" => $ID_Patient
				);
			
				$this->Db->insert("re_users_centers", $data);
			}
		}
	}

	public function assignPermissions() {
		$users = POST("users");
		$ID_Patient = POST("ID_Patient");
	
		$this->Db->deleteBySQL("ID_User_Patient = '$ID_Patient'", "re_users_patients");

		if($users) {
			for($i = 0; $i <= count($users) - 1; $i++) {
				$data = array(
					"ID_User" => $users[$i],
					"ID_User_Patient" => $ID_Patient
				);

				$this->Db->insert("re_users_patients", $data);
			}
		}
	}

	public function getCenters() {
		$query = "SELECT * FROM zan_centers";

		return $this->Db->query($query);
	}
	
	public function getByType($IDType = 6) {
		$query = "SELECT * FROM zan_users WHERE ID_Type_User IN ($IDType)";
					
		return $this->Db->query($query);
	}

	public function getAssignedCenters($ID_Center, $ID_Patient) {
		$query = "SELECT * FROM zan_re_users_centers WHERE ID_Center = '$ID_Center' AND ID_User = '$ID_Patient'";

		return $this->Db->query($query);
	}

	public function getAssigned($ID_User, $ID_Patient) {
		$query = "SELECT * FROM zan_re_users_patients WHERE ID_User = '$ID_User' AND ID_User_Patient = '$ID_Patient'";

		return $this->Db->query($query);
	}
	
	public function getPatient($ID) {
		$query = "SELECT * FROM zan_users WHERE ID_User = '$ID'";
		
		$data = $this->Db->query($query);
		
		return ($data) ? $data[0] : FALSE; 
	}
	
	public function all($limit = 25) { 
		if(SESSION("ZanUserTypeID") == 1) { 
			$query = "SELECT * FROM zan_users WHERE ID_Type_User = '4' AND Situation != 'Deleted' ORDER BY ID_User DESC LIMIT {$limit}";
		} else {
			$userID = SESSION("ZanUserID");

			$query = "SELECT * FROM zan_users WHERE Situation != 'Deleted' AND ID_User IN (SELECT zan_re_users_patients.ID_User_Patient FROM zan_re_users_patients WHERE ID_User = '$userID') ORDER BY ID_User DESC LIMIT {$limit}";
		}

		$data = $this->Db->query($query);
		
		return $data;
	}

	public function count() {
		if(SESSION("ZanUserTypeID") === 1) {
			$query = "SELECT count(*) as count FROM zan_users WHERE Situation != 'Deleted' ORDER BY ID_User DESC";
		} else {
			$userID = SESSION("ZanUserID");

			$query = "SELECT count(*) as count FROM zan_users WHERE Situation != 'Deleted' AND ID_User IN (SELECT zan_re_users_patients.ID_User_Patient FROM zan_re_users_patients WHERE ID_User = '$userID') ORDER BY ID_User DESC";			
		}
		
		$data = $this->Db->query($query);
		
		return $data[0]["count"];
	}
	
	public function search($search) {
		$query = "SELECT * FROM zan_users WHERE ID_Type_User = '4' AND (Name LIKE '%$search%' OR Last_Name LIKE '%$search%' OR Maiden_Name LIKE '%$search%')";
		
		return $this->Db->query($query);		
	}
}
