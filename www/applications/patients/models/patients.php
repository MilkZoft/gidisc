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

	public function assignPermissions() {
		$users = POST("users");
		$ID_Patient = POST("ID_Patient");
	
		$this->Db->deleteBySQL("ID_Patient = '$ID_Patient'", "re_users_patients");

		if($users) {
			for($i = 0; $i <= count($users) - 1; $i++) {
				$data = array(
					"ID_User" => $users[$i],
					"ID_Patient" => $ID_Patient
				);

				$this->Db->insert("re_users_patients", $data);
			}
		}
	}
	
	public function getByType($IDType = 6) {
		$query = "SELECT * FROM zan_users 
					LEFT JOIN zan_re_user_person ON 
						zan_re_user_person.ID_User = zan_users.ID_User 
					LEFT JOIN zan_people ON 
						zan_people.ID_Person = zan_re_user_person.ID_Person 
					WHERE zan_users.ID_Type_User IN ($IDType)";
					
		return $this->Db->query($query);
	}

	public function getAssigned($ID_User, $ID_Patient) {
		$query = "SELECT * FROM zan_re_users_patients WHERE ID_User = '$ID_User' AND ID_Patient = '$ID_Patient'";

		return $this->Db->query($query);
	}
	
	public function getPatient($ID) {
		$query = "SELECT * FROM zan_patients 
				LEFT JOIN zan_re_user_person ON zan_re_user_person.ID_Person = zan_patients.ID_Person 
				LEFT JOIN zan_people ON zan_people.ID_Person = zan_patients.ID_Person 
				LEFT JOIN zan_users ON zan_users.ID_User = zan_re_user_person.ID_User 
				WHERE zan_patients.ID_Patient = '{$ID}'";
		
		$data = $this->Db->query($query);
		
		return ($data) ? $data[0] : FALSE; 
	}
	
	public function all($limit = 25) {
		if(SESSION("ZanUserTypeID") === 1) {
			$query = "SELECT * FROM zan_patients 
					LEFT JOIN zan_re_user_person ON zan_re_user_person.ID_Person = zan_patients.ID_Person 
					LEFT JOIN zan_people ON zan_people.ID_Person = zan_patients.ID_Person 
					LEFT JOIN zan_users ON zan_users.ID_User = zan_re_user_person.ID_User 
					WHERE zan_patients.Situation != 'Deleted' ORDER BY ID_Patient DESC LIMIT {$limit}";
		} else {
			$userID = SESSION("ZanUserID");

			$query = "SELECT * FROM zan_patients 
					LEFT JOIN zan_re_user_person ON zan_re_user_person.ID_Person = zan_patients.ID_Person 
					LEFT JOIN zan_people ON zan_people.ID_Person = zan_patients.ID_Person 
					LEFT JOIN zan_users ON zan_users.ID_User = zan_re_user_person.ID_User 
					WHERE zan_patients.Situation != 'Deleted' AND zan_patients.ID_Patient IN (SELECT zan_re_users_patients.ID_Patient FROM zan_re_users_patients WHERE ID_User = '$userID') ORDER BY ID_Patient DESC LIMIT {$limit}";
		}
		
		$data = $this->Db->query($query);
		
		return $data;
	}

	public function count() {
		if(SESSION("ZanUserTypeID") === 1) {
			$query = "SELECT count(*) as count FROM zan_patients 
					LEFT JOIN zan_re_user_person ON zan_re_user_person.ID_Person = zan_patients.ID_Person 
					LEFT JOIN zan_people ON zan_people.ID_Person = zan_patients.ID_Person 
					LEFT JOIN zan_users ON zan_users.ID_User = zan_re_user_person.ID_User 
					WHERE zan_patients.Situation != 'Deleted' ORDER BY ID_Patient DESC";
		} else {
			$userID = SESSION("ZanUserID");

			$query = "SELECT count(*) as count FROM zan_patients 
					LEFT JOIN zan_re_user_person ON zan_re_user_person.ID_Person = zan_patients.ID_Person 
					LEFT JOIN zan_people ON zan_people.ID_Person = zan_patients.ID_Person 
					LEFT JOIN zan_users ON zan_users.ID_User = zan_re_user_person.ID_User 
					WHERE zan_patients.Situation != 'Deleted' AND zan_patients.ID_Patient IN (SELECT zan_re_users_patients.ID_Patient FROM zan_re_users_patients WHERE ID_User = '$userID') ORDER BY ID_Patient DESC";			
		}
		
		$data = $this->Db->query($query);
		
		return $data[0]["count"];
	}
	
	public function search($search) {
		$query = "SELECT * FROM zan_people WHERE Name LIKE '%$search%' OR  Last_Name LIKE '%$search%' OR  Maiden_Name LIKE '%$search%'";
		
		return $this->Db->query($query);		
	}
}
