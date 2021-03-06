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
	
	public function getByType($IDType = 6) {
		$query = "SELECT * FROM zan_users 
					LEFT JOIN zan_re_user_person ON 
						zan_re_user_person.ID_User = zan_users.ID_User 
					LEFT JOIN zan_people ON 
						zan_people.ID_Person = zan_re_user_person.ID_Person 
					WHERE zan_users.ID_Type_User = $IDType";
					
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
		$query = "SELECT * FROM zan_patients 
				LEFT JOIN zan_re_user_person ON zan_re_user_person.ID_Person = zan_patients.ID_Person 
				LEFT JOIN zan_people ON zan_people.ID_Person = zan_patients.ID_Person 
				LEFT JOIN zan_users ON zan_users.ID_User = zan_re_user_person.ID_User 
				WHERE zan_patients.Situation != 'Deleted' ORDER BY ID_Patient DESC LIMIT {$limit}";
		
		$data = $this->Db->query($query);
		
		return $data;
	}

	public function count() {
		$query = "SELECT count(*) as count FROM zan_patients 
				LEFT JOIN zan_re_user_person ON zan_re_user_person.ID_Person = zan_patients.ID_Person 
				LEFT JOIN zan_people ON zan_people.ID_Person = zan_patients.ID_Person 
				LEFT JOIN zan_users ON zan_users.ID_User = zan_re_user_person.ID_User 
				WHERE zan_patients.Situation != 'Deleted' ORDER BY ID_Patient DESC";
		
		$data = $this->Db->query($query);
		
		return $data[0]["count"];
	}
	
	public function search($search) {
		$query = "SELECT * FROM zan_re_user_person
					LEFT JOIN zan_patients ON
						zan_patients.ID_Person = zan_re_user_person.ID_Person
					LEFT JOIN zan_users ON
						zan_users.ID_User = zan_re_user_person.ID_User 
					LEFT JOIN zan_people ON
						zan_people.ID_Person = zan_re_user_person.ID_Person						
					LEFT JOIN zan_patients ON                                
						zan_people.ID_Person= zan_patients.ID_Person	  
					WHERE zan_people.Name LIKE '%$search%' OR  zan_people.Surname LIKE '%$search%' OR  zan_people.Email LIKE '%$search%' OR  zan_users.Username LIKE '%$search%' OR CONCAT(zan_people.Name, ' ', zan_people.Last_Name, ' ', zan_people.Maiden_Name) LIKE '%$search%'";
					//Sustiur Surname por Lastname y poner un Maiden_Name
		return $this->Db->query($query);
		
	}
}
