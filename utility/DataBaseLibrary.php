<?php

class DataBaseManager {

	private $mysqli =NULL;
	
	public function __construct() {}

	
	public function connectToDb($localhost = "localhost", $username = "chris", $password = "12345678", $dbName = "testdatabase") {
		$this->mysqli = new mysqli($localhost, $username, $password, $dbName);
		if($this->mysqli->connect_errno) {
			printf("Connect failed: %s\n", $this->mysqli->connect_error);
			exit();
			return FALSE;
		} else {
			//echo "Host information: " . $this->mysqli->host_info . "<br />";
			return $this->mysqli;
		}
	}
	
	public function closeDb() {
		if($this->mysqli->stat() != FALSE)
			$this->mysqli->close();
		else
			printf("Error closing the Database.");
	}
	
	public function real_escape_string($string) {
		return $this->mysqli->real_escape_string($string);
	}
	
	//$choice: "store" for store_result(), "get" for get_result()
	public function executeQuery($query) {
		if($this->mysqli) {
			$res = $this->mysqli->query($query) or die($this->mysqli->error);
			return $res;
		}
	}
	
	public function getInsertID() {
		if($this->mysqli)
			return $this->mysqli->insert_id;
	}
	
}



?>