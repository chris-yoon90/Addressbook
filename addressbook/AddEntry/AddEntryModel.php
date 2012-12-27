<?php
	class AddEntryModel {
		
		private $observers = null;
		private $title;
		private $style;
		
		public function __construct() {}
		
		public function attachViews(/*any number of observers*/) {
			if(func_num_args() == 0) {
				$this->observers = null;
			} else {
				$this->observers = func_get_args();
			}
		}
		
		public function notifyViews() {
			//var_dump($this->observers);
			if($this->observers != null) {
				foreach ($this->observers as $o) {
					$o->buildPage($this);
				}
			}
		}
		
		public function validateData() {
			//TODO------------------------------------
			return true;
		}
		
		public function setStyleSheet($style) {
			$this->style = $style;
		}
		
		public function setTitle($title) {
			$this->title = $title;
		}
		
		public function getTitle() {
			return $this->title;
		}
		
		public function getStyleSheet() {
			return $this->style;
		}
		
		public function addToDatabase() {
			$DBmanager = new DataBaseManager();
			$DBmanager->connectToDB();
			$e_arr;
			
			//var_dump($_POST);
			
			foreach($_POST as $key => $value) {
				$e_arr["$key"] = $DBmanager->real_escape_string($value);
			}
			
			//var_dump($e_arr);
			$e_user_id = $DBmanager->real_escape_string($_SESSION['user_id']);
			
			$query_for_master_name = "INSERT INTO master_name (id, user_id, date_added, date_modified, first_name, last_name)
														VALUES ('NULL', '". $e_user_id . "', now(), now(), '" . $e_arr['first_name'] . "' , '" . $e_arr['last_name'] ."')";
			
			$DBmanager->executeQuery($query_for_master_name);
			$master_id = $DBmanager->getInsertID();
			
			$response = true;
			if($e_arr['address'] && $e_arr['city'] && ($e_arr['province'] !== "default") && $e_arr['zipcode']) {
				$query_for_address = "INSERT INTO address (id, user_id, master_id, date_added, date_modified, address, city, province, zipcode, type)
											VALUES ('NULL' , '". $e_user_id . "', '".$master_id . "', now(), now(), '" . $e_arr['address'] . "', '" . $e_arr['city'] . "', '" 
											. $e_arr['province'] . "', '" . $e_arr['zipcode'] . "', '" . $e_arr['add_type'] . "')";		
				$response = $DBmanager->executeQuery($query_for_address);
			}
			if($e_arr['tel_number']) {
				$query_for_telephone= "INSERT INTO telephone (id, user_id, master_id, date_added, date_modified, tel_number, type) 
												VALUES ('NULL', '". $e_user_id . "','" . $master_id . "', now(), now(), '" . $e_arr['tel_number'] . "','" . $e_arr['tel_type'] . "')";
				$response = $DBmanager->executeQuery($query_for_telephone);
			}
			if($e_arr['fax_number']) {
				$query_for_fax= "INSERT INTO fax (id, user_id, master_id, date_added, date_modified, fax_number, type) 
												VALUES ('NULL', '". $e_user_id . "','" . $master_id . "', now(), now(), '" . $e_arr['fax_number'] . "','" . $e_arr['fax_type'] . "')";
				$response = $DBmanager->executeQuery($query_for_fax);
			}
			if($e_arr['email']) {
				$query_for_email= "INSERT INTO email (id, user_id, master_id, date_added, date_modified, email, type) 
												VALUES ('NULL', '". $e_user_id . "','" . $master_id . "', now(), now(), '" . $e_arr['email'] . "','" . $e_arr['email_type'] . "')";
				$response = $DBmanager->executeQuery($query_for_email);
			}
			if($e_arr['note']) {
				$query_for_description= "INSERT INTO description (id, user_id, master_id, date_added, date_modified, note) 
												VALUES ('NULL', '". $e_user_id . "','" . $master_id . "', now(), now(), '" . $e_arr['note'] . "')";
				$response = $DBmanager->executeQuery($query_for_description);
			}
			
			
			$DBmanager->closeDb();
			return $response;
		}
	
	
	}
?>