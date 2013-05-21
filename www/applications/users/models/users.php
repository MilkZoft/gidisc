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
			$data = $this->Db->findBySQL("Situation != 'Deleted'", $this->table, NULL, "ID_User DESC", $limit);	
		} else {
			$data = $this->Db->findBy("Situation", "Deleted", $this->table, NULL, "ID_User DESC", $limit);
		}
		
		return $data;	
	}
	
	private function editOrSave() {
		$this->Files = $this->core("Files");

		$this->photo = FILES("photo");
		
		if($this->photo["name"] != "") {
			$dir = "www/lib/files/images/users/photos/";

			$this->photo = $this->Files->uploadimage($dir, "photo", "resize", FALSE, TRUE, FALSE);
			
			if(isset($this->photo["alert"])) {
				return $this->photo["alert"];
			}
		}
				
		$username  = POST("username");
	
		if(is_null($username)) {
			return getAlert("An error occurred :("); 
		}
		
		if(POST("save")) {
			$pwd      = POST("pwd", "encrypt");
		} else {
			$username = POST("username");
			$pwd      = POST("pwd", "encrypt");
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
			"Username" 	   => $username,
			"ID_Type_User" => (string) POST("id_type_user"),
			"Name"         => (string) POST("name"),
			"Last_Name"    => (string) POST("last_name"),
			"Maiden_Name"  => (string) POST("maiden_name"),
			"Email"        => (string) POST("email"),
			"Address"  	   => (string) POST("address"),
			"Phone"        => (string) POST("phone"),
			"Father_Name"  => (string) POST("fname"),
			"Mother_Name"  => (string) POST("mname"),
			"Father_Profession" => (string) POST("profession"),
			"Birthday"     => (string) POST("birthday"),
			"Date_Entry"   => now(4),
			"Background"   => (string) POST("background"),
			"Photo" 	   => isset($this->photo["medium"]) ? $this->photo["medium"] : null,
			"Levels"       => (string) POST("levels"),
			"CEO"          => (string) POST("ceo"),
			"Levels_Directors" => (string) POST("levels_directors"),
			"Coordinator"  => (string) POST("coordinator"),
			"Contact"      => (string) POST("contact")
		);

		if(!is_null($pwd)) {
			$data["Pwd"] = $pwd;
		}
		
		$this->Data->ignore(array("ceo", "id_type_user", "fname", "mname", "username", "father", "mother", "last_name", "maiden_name", "center", "type", "pwd", "name", "surname", "background", "therapist", "situation", "address", "phone", "grade", "profession", "birthday","photo"));
		
		$this->data = $this->Data->proccess($data, $validations);
		
		if(isset($this->data["error"])) {
			return $this->data["error"];
		}
	}
	
	private function save() {
		$id = $this->Db->insert($this->table, $this->data);
		showAlert("The user has been saved correctly", path("users/cpanel/add"));	
	}
	
	private function dataExits($ID, $data) {
		$data = $this->Db->query("SELECT * FROM zan_users WHERE Email = '". $data["Email"] ."' OR Username = '". $data["Username"] ."' AND ID_User != $ID");

		return $data;
	}

	private function getIDPatient($IDPerson) {
		return $this->Db->select("ID_Patient")->from("patients")->where("ID_Person", $IDPerson)->get();
	}

	private function edit() {
		$editUser = $this->Db->update($this->table, $this->data, POST("ID"));
		
		if($editUser) {
			echo showAlert("The user has been edit correctly", path("users/cpanel/results"));
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
		
		$query = "SELECT * FROM zan_users WHERE ID_Type_User = $IDType";
							
		return $this->Db->query($query);
	}

	public function getByUsersType($IDType = 5) {
		$this->Db->table("people");
		
		$query = "SELECT * FROM zan_users WHERE ID_Type_User = $IDType";
					
		return $this->Db->query($query);
	}
}
