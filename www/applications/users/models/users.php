<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class Users_Model extends ZP_Model {
	
	public function __construct() {
		$this->Db = $this->db();
		
		$this->Data = $this->core("Data");

		$this->helpers();
		
		$this->table = "users";
		
		$this->Data->table($this->table);
		
		$this->application = "users";
	}

	/*public function fixUsers() {
		$this->Db->table($this->table);
		
		$data = $this->Db->findAll();

		foreach($data as $user) {
			$newPwd = encrypt($user["Pwd"]);

			$this->Db->updateBySQL("users", "Pwd = '$newPwd' WHERE ID_User = '". $user["ID_User"] ."'");
		}
	}*/

	public function cpanel($action, $limit = NULL, $order = "Language DESC", $search = NULL, $field = NULL, $trash = FALSE) {
		if($action === "edit" or $action === "save") {
			$validation = $this->editOrSave();
			
			if($validation) {
				return $validation;
			}
		}
		
		if($action === "all") {
			return $this->all($trash, $order, $limit);
		} elseif($action === "edit") {
			return $this->edit();															
		} elseif($action === "save") {
			return $this->save();
		} elseif($action === "search") {
			return $this->seek($search, $field, $order);
		}
	}
	
	private function seek($search, $field, $order) {
		$this->Db->table($this->table);

		if($search and $field) {
			if($field === "ID") {
				$data = $this->Db->find($search);
			} else {
				$data  = $this->Db->findBySQL("$field LIKE '%$search%'", $this->table, NULL, $order);
			}
		} else {
			return FALSE;
		}
		
		return $data;
	}
	
	private function all($trash, $order, $limit) {
		if(!$trash) {
			$data = $this->Db->findBySQL("Situation != 'Deleted'", $this->table, NULL, $order, $limit);	
		} else {
			$data = $this->Db->findBy("Situation", "Deleted", $this->table, NULL, $order, $limit);
		}
		
		return $data;	
	}
	
	private function editOrSave() {
		$this->Files = $this->core("Files");

		$this->photo = FILES("photo");
		
		if($this->photo["name"] != "") {
			$dir = "www/lib/files/images/users/photos/";

			$this->photo = $this->Files->uploadimage($dir, "photo");
			
			if(isset($this->photo["alert"])) {
				return $this->photo["alert"];
			}
		}
		
		$this->RFC = $this->library("rfc", "RFC", NULL, "users");

		$this->RFC->init(POST("name"), POST("last_name"), POST("maiden_name"), POST("birthday"));
		//public function library($name, $className = NULL, $params = array(), $application = NULL)
		
		$username  = $this->RFC->rfc;
	
		if(is_null($username)) {
			return getAlert("An error occurred :("); 
		}
		
		if(POST("save")) {
			$pwd      = $username;
		} else {
			$username = POST("username");
			$pwd      = POST("pwd");
		}
		
		$validations = array(
			"email"	   => "email?",
			"exists"   => array(
							"Username" => $username,
						  ),
			"exists"   => array(
							"Email" => POST("email"),
						  )						  						  
		);

		$data = array(
			"Username" => $username,
			"Pwd" 	   => encrypt(encode($pwd)),
			"ID_Type_User" => POST("type")
		);

		$this->Data->ignore(array("username", "father", "mother", "last_name", "maiden_name", "center", "type", "pwd", "name", "surname", "background", "therapist", "situation", "address", "phone", "grade", "profession", "birthday","photo"));
		
		$this->data = $this->Data->proccess($data, $validations);

		if(isset($this->data["error"])) {
			return $this->data["error"];
		}
	}
	
	private function save() {
		$insertID = $this->Db->insert($this->table, $this->data);
		
		$data = array( 
			"Name"           => POST("name"),
			"Last_Name"      => POST("last_name"),
			"Maiden_Name"    => POST("maiden_name"),
			"Email"      	 => POST("email"),
			"Address"    	 => POST("address"),
			"Phone"      	 => POST("phone"),
			"Profession" 	 => POST("profession"),
			"Birthday"   	 => POST("birthday"),
			"Date_Entry"     => now(4)			
		);
		
		$insertPerson = $this->Db->insert("people", $data);
		
		$data = array(
			"ID_User"   => $insertID,
			"ID_Person" => $insertPerson
		);
		
		$insertRel = $this->Db->insert("re_user_person", $data);
		
		//Add patient
		if(POST("type") == 4) {
			$data = array(
				"ID_Person"    => $insertPerson,
				"ID_Father"    => POST("father"),
				"ID_Mother"    => POST("mother"),
				"ID_Therapist" => POST("therapist"),
				"Background"   => POST("background"),
				"Situation"    => (POST("situation") == 1) ? "Active" : "Inactive"
			);		
		
			$insertPatient = $this->Db->insert("patients", $data);
			
			$data = array(
				"ID_Patient" => $insertPatient,
				"ID_Center"  => POST("center")
			);
			
			$insertRelCenter = $this->Db->insert("re_patients_centers", $data);
			
			if(isset($this->photo["small"])) {
				$data = array(
					0 => array(
						"ID_Type_Photo" => 1,
						"ID_Person"     => $insertPerson,
						"URL"           => $this->photo["small"]
					),

					1 => array(
						"ID_Type_Photo" => 2,
						"ID_Person"     => $insertPerson,
						"URL"           => $this->photo["medium"]
					),

					2 => array(
						"ID_Type_Photo" => 3,
						"ID_Person"     => $insertPerson,
						"URL"           => $this->photo["original"]
					)
				);

				$insertPhoto = $this->Db->insertBatch("people_photos", $data);
			}
		}
		
		return getAlert("The user has been saved correctly", "success");	
	}

	private function saveUser() {
			
	}

	private function savePerson() {
		
	}	
	
	private function dataExits($ID, $data) {
		$data = $this->Db->query("SELECT * FROM zan_users WHERE Email = '". $data["Email"] ."' OR Username = '". $data["Username"] ."' AND ID_User != $ID");

		return $data;
	}

	private function getIDPatient($IDPerson) {
		return $this->Db->select("ID_Patient")->from("patients")->where("ID_Person", $IDPerson)->get();
	}

	private function edit() {
		$results = $this->dataExits(POST("ID"), $this->data);
		
		if($results) {
			$editUser = $this->Db->update($this->table, $this->data, POST("ID"));
			
			$findIDPerson = $this->getReUserPerson(POST("ID"));
			
			$data = array( 
				"Name"           => POST("name"),
				"Last_Name"      => POST("last_name"),
				"Maiden_Name"    => POST("maiden_name"),
				"Email"      	 => POST("email"),
				"Address"    	 => POST("address"),
				"Phone"      	 => POST("phone"),
				"Grade"      	 => POST("grade"),
				"Profession" 	 => POST("profession"),
				"Birthday"   	 => POST("birthday"),
				"Date_Entry"     => now(4)			
			);

			$IDPerson = $findIDPerson[0]["ID_Person"];

			$edit = $this->Db->update("people", $data, $IDPerson);
			
			if(POST("type") == 4) {
				$data = array(
					"ID_Father"  => 11,
					"ID_Mother"  => 12,
					"Background" => POST("background"),
					"Therapist"  => POST("therapist"),
					"Situation"  => POST("situation")
				);

				$edit = $this->Db->updateBySQL("patients", $data, $IDPerson, "ID_Person");

				$patients = $this->getIDPatient($IDPerson);

				$IDPatient = $patients[0]['ID_Patient'];

				if(isset($this->photo["small"])) {
					$this->deletePhotos($IDPatient);

					$data = array(
						0 => array(
							"ID_Patient" => $IDPatient,
							"URL"        => $this->photo["small"]
						),

						1 => array(
							"ID_Patient" => $IDPatient,
							"URL"        => $this->photo["medium"]
						),

						2 => array(
							"ID_Patient" => $IDPatient,
							"URL"        => $this->photo["original"]
						)
					);

					$insertPhoto = $this->Db->insertBatch("patients_photos", $data);
				}
			}									    
			
			if($edit) {
				return getAlert("The user has been edit correctly", "success");
			} else {
				return getAlert("An error occurred :(");
			}
		} else {
			return getAlert("An error occurred :(");
		}
	}

	public function deletePhotos($ID) {
		$data = $this->Db->findBy("ID_Patient", $ID, "patients_photos");

		$i = 0;

		foreach($data as $URL) {
			$URL = $data[$i]["URL"];

			if(is_file($URL)) {
				chmod($url, 0666);
				unlink($url);	
			}
	
			$i++;
		}

		$this->Db->deleteBySQL("ID_Patient = $ID", "patients_photos");
	}

	public function isAdmin($session = FALSE) {
		if($session) {
			$username = SESSION("ZanUser");
			$password = SESSION("ZanUserPwd");
		} else {
			$username = POST("username");
			$password = POST("password", "encrypt");
		}

		$query = "Username = '$username' AND Pwd = '$password' AND Situation = 'Active'";
		$data  = $this->Db->findBySQL($query, $this->table);
		
		return $data;
	}

	public function isMember($sessions = FALSE) {
		if($sessions) {		
			$username = SESSION("ZanUser");
			$password = SESSION("ZanUserPwd");						
		} else {			
			$username = POST("username");
			$password = POST("password", "encrypt");
		}
		
		$query = "Username = '$username' AND Pwd = '$password' AND Situation = 'Active'";
		$data  = $this->Db->findBySQL($query, $this->table);
	
		if($data) {
			return TRUE;
		}
		
		return FALSE;
	}

	public function count($type = 4) {
		return $this->Db->countBySQL("ID_Type_User = '$type'", "users");
	}

	public function lastPacient() {
		$data = $this->Db->findLast("users", "ID_Type_User = '4' AND Situation = 'Active'");
		
		if(isset($data[0]["Username"])) {
			return $data[0]["Username"];
		} else {
			return __(_("Nobody"));
		} 
	}
	
	public function getUserData($sessions = FALSE) {		
		if($sessions) {		
			$username = SESSION("ZanUser");
			$password = SESSION("ZanUserPwd");						
		} else {			
			$username = POST("username");
			$password = POST("password", "encrypt");
		}
		
		$query = "Username = '$username' AND Pwd = '$password' AND Situation = 'Active'";
		$data  = $this->Db->findBySQL($query, $this->table);	
		
		$user = FALSE;
		
		if($data) {
			$user[0]["ID_User"]  = $data[0]["ID_User"];
			$user[0]["Username"] = $data[0]["Username"];
			$user[0]["Password"] = $data[0]["Pwd"];
			
			$data = $this->Db->findBy("ID_Type_User", $data[0]["ID_Type_User"], "type_users");

			if($data) {							
				$user[0]["ID_Type_User"] = $data[0]["ID_Type_User"];
				$user[0]["Type"]         = $data[0]["Type"];
			} else {
				return FALSE;
			}
		}
			
		return $user;
	}
	
	public function setToken($ID = 0) {
		$token = code();
		
		$data = array( 
			"ID_User"    => $ID,
			"Token"      => $token,
			"IP"         => getIP(),
			"Start_Date" => now(4)		
		);
		
		$ID_Token = $this->Db->insert("tokens", $data);
		
		if(!$ID_Token) {
			return FALSE;
		}
		
		return $token;
	}
	
	public function verifyToken() {
		$this->Db->table("tokens");
		$token = $this->Db->findBy("ID_User", SESSION("ZanUserID"), "tokens", NULL, "ID_Token DESC", 1);
		
		if(!$token) {
			redirect("cpanel" . _sh . "logout");
		}
		
		if($token[0]["Token"] !== SESSION("ZanUserToken")) {
			redirect("cpanel" . _sh . "logout");
		}
		
		return TRUE;
	}

	public function getReUserPerson($ID_User) {
		return $this->Db->find($ID_User, "re_user_person");
	}

	public function getUserPerson($ID_User) {
		$data = $this->Db->query("select * FROM zan_re_user_person
								  LEFT JOIN zan_patients ON
								  	zan_patients.ID_Person = zan_re_user_person.ID_Person
								  LEFT JOIN zan_people ON
								  	zan_people.ID_Person = zan_re_user_person.ID_Person
								  LEFT JOIN zan_users ON
								  	zan_users.ID_User = zan_re_user_person.ID_User						  
								  WHERE zan_re_user_person.id_user = $ID_User");

		return $data;
	}

	public function getPhoto($ID_Patient) {
		return $this->Db->query("SELECT distinct(id_patient),url FROM zan_patients_photos WHERE id_patient = '$ID_Patient' group by id_patient");
	}

	public function getByID($table, $ID) {
		return $this->Db->find($ID, $table);
	}

	public function getTypesUsers() {
		return $this->Db->findAll("type_users");
	}
	
	public function search2($search) {
		$query = "SELECT * FROM zan_re_user_person
					LEFT JOIN zan_users ON
						zan_users.ID_User = zan_re_user_person.ID_User 
					LEFT JOIN zan_people ON
						zan_people.ID_Person = zan_re_user_person.ID_Person							  
					WHERE 
					zan_people.Name LIKE '%$search%' OR 
					zan_people.Last_Name LIKE '%$search%' OR 
					zan_people.Maiden_Name LIKE '%$search%' OR 
					zan_people.Email LIKE '%$search%' OR 
					CONCAT(zan_people.Name, ' ', zan_people.Last_Name, ' ', zan_people.Maiden_Name) LIKE '%$search%' OR 
					zan_users.Username LIKE '%$search%'";
	
		return $this->Db->query($query);
	}
	
	public function search($search) {
		$query = "SELECT * FROM zan_re_user_person
					LEFT JOIN zan_patients ON
						zan_patients.ID_Person = zan_re_user_person.ID_Person
					LEFT JOIN zan_users ON
						zan_users.ID_User = zan_re_user_person.ID_User 
					LEFT JOIN zan_people ON
						zan_people.ID_Person = zan_re_user_person.ID_Person							  
					WHERE 
					zan_people.Name LIKE '%$search%' OR 
					zan_people.Last_Name LIKE '%$search%' OR 
					zan_people.Maiden_Name LIKE '%$search%' OR 
					zan_people.Email LIKE '%$search%' OR 
					CONCAT(zan_people.Name, ' ', zan_people.Last_Name, ' ', zan_people.Maiden_Name) LIKE '%$search%' OR 
					zan_users.Username LIKE '%$search%'";
	
		return $this->Db->query($query);
	}

	public function getPhotos() {
		$query = "select distinct zan_patients.ID_Patient, url, name from zan_patients left join zan_patients_photos ON zan_patients.ID_Patient = zan_patients_photos.ID_Patient LEFT JOIN zan_people ON zan_people.ID_Person = zan_patients.ID_Person where url != '' group by zan_patients.ID_Patient order by rand() limit 4";

		return $this->Db->query($query);
	}
	
	public function getByType($IDType = 5) {
		$this->Db->table("people");
		
		$query = "SELECT * FROM zan_users 
					LEFT JOIN zan_re_user_person ON 
						zan_re_user_person.ID_User = zan_users.ID_User 
					LEFT JOIN zan_people ON 
						zan_people.ID_Person = zan_re_user_person.ID_Person 
					WHERE zan_users.ID_Type_User = $IDType";
					
		return $this->Db->query($query);
	}
}
