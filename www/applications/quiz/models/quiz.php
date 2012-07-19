<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class Quiz_Model extends ZP_Model {
	
	public function __construct() {
		$this->Db = $this->db();
		
		$this->helper(array("time", "alerts", "router"));
		
		$this->table    = "test";
		$this->language = whichLanguage(); 

		$this->Data = $this->core("Data");

		$this->Data->table($this->table);
	}
	
	public function getAll() {
		return $this->Db->findAll("type_tests");
	}
}
