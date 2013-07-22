<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class Centers_Model extends ZP_Model {
	
	public function __construct() {
		$this->Db   = $this->db();
		$this->Data = $this->core("Data");

		$this->helpers();
		
		$this->table = "centers";
		
		$this->Users_Model = $this->model("Users_Model");

		$token = $this->Users_Model->verifyToken();
	}

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
		if($search and $field) {
			if($field === "ID") {
				$data = $this->Db->find($search, $this->table);
			} else {
				$field = "Name";
				$order = str_replace("title", "Name", $order);
				$data  = $this->Db->findBySQL("$field LIKE '%$search%'", $this->table, NULL, $order);
			}
		} else {
			return FALSE;
		}
		
		return $data;
	}
	
	public function all($trash = FALSE, $order = NULL, $limit = NULL) {
		if(!$trash) {
			if(SESSION("ZanUserPrivilege") === "Super Admin") {
				$data = $this->Db->findBySQL("Situation != 'Deleted'", $this->table, NULL, $order, $limit);
			} else {
				$data = $this->Db->findBySQL("Situation != 'Deleted'", $this->table, NULL, $order, $limit);
			}	
		} else {
			if(SESSION("ZanUserPrivilege") === "Super Admin") {
				$data = $this->Db->findBy("Situation", "Deleted", $this->table, NULL, $order, $limit);
			} else {
				$data = $this->Db->findBySQL("Situation = 'Deleted'", $this->table, NULL, $order, $limit);
			}
		}
		
		return $data;	
	}
	
	private function editOrSave() {
		$validations = array(
			"name"     	=> "required",
			"address"   => "required",
			"type" 		=> "required",
			"situation" => "required"
		);
		
		$this->Data->change("type", "ID_Type_Center");
		
		$data = array(
			"ID_User"    => SESSION("ZanUserID"),
			"Start_Date" => now(4),
			"End_Date"   => now(4)
		);

		$this->data = $this->Data->proccess($data, $validations);
		
		if(isset($this->data["error"])) {
			return $this->data["error"];
		}
	}
	
	private function save() {
		$insertID = $this->Db->insert($this->table, $this->data);
		
		if($insertID) {
			return getAlert("The center has been saved correctly", "success");
		} else {
			return getAlert("An error occurred :(");
		}
	
	}
	
	private function edit() {
		$edit = $this->Db->update($this->table, $this->data, POST("ID"));
		
		if($edit) {
			return getAlert("The center has been edit correctly", "success");
		} else {
			return getAlert("An error occurred :(");
		}
	}

	public function getUsers($ID) {
		$query = "SELECT * FROM zan_users WHERE ID_User IN (SELECT ID_User FROM zan_re_users_centers WHERE ID_Center = '$ID')";

		return $this->Db->query($query);
	}

	public function count() {
		return $this->Db->countAll("centers", $this->table);
	}

	public function getTypesCenters() {
		return $this->Db->findAll("type_centers");
	}
	
	public function getByID($ID) {
		return $this->Db->find($ID, $this->table);
	}
	
	public function search($search) {
		return $this->Db->query("SELECT * FROM zan_centers WHERE Name LIKE '%$search%'");
	}
}
