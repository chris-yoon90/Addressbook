<?php
	
	class AddressbookModel {
		
		private $ContactList;
		private $observers = null;
		
		//------------------------------
		private $master_name;
		private $master_address;
		private $master_telephone;
		private $master_fax ;
		private $master_email;
		private $master_note;
		private $IsMasterInfoSet = FALSE;
		//------------------------------
		
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
		
		public function setContactList() {
			$DBmanager = new DataBaseManager();
			$DBmanager->connectToDB();
			
			$e_user_id = $DBmanager->real_escape_string($_SESSION['user_id']);
			$query = "SELECT id, CONCAT_WS(' ', first_name, last_name) AS display_name FROM master_name WHERE user_id='".$e_user_id. "' ORDER BY first_name, last_name ";
			
			$result = $DBmanager->executeQuery($query);
			$DBmanager->closeDb();
			if($result->num_rows < 1) {
				$this->ContactList = NULL;
			} else {
				$res_array = null;
				while($recs = $result->fetch_assoc()) {
					$res_array[] = $recs;
				}
				$this->ContactList = $res_array;
			}
			
		}
		
		public function deleteContact() {
			$DBmanager = new DataBaseManager();
			$DBmanager->connectToDB();
			$e_user_id = $DBmanager->real_escape_string($_SESSION['user_id']);
			$e_selected_id = $DBmanager->real_escape_string($_SESSION['selected-id']);
			
			$delete_master = "DELETE FROM master_name WHERE id = '" . $e_selected_id . "' AND user_id = '" . $e_user_id . "'";
			$delete_address = "DELETE FROM address WHERE master_id = '" . $e_selected_id . "' AND user_id = '" . $e_user_id . "'";
			$delete_telephone = "DELETE FROM telephone WHERE master_id = '" . $e_selected_id . "' AND user_id = '" . $e_user_id . "'";
			$delete_fax = "DELETE FROM fax WHERE master_id = '" . $e_selected_id . "' AND user_id = '" . $e_user_id . "'";
			$delete_email = "DELETE FROM email WHERE master_id = '" . $e_selected_id . "' AND user_id = '" . $e_user_id . "'";
			$delete_note = "DELETE FROM description WHERE master_id = '" . $e_selected_id . "' AND user_id = '" . $e_user_id . "'";
			
			$res = $DBmanager->executeQuery($delete_master);
			$res = $DBmanager->executeQuery($delete_address);
			$res = $DBmanager->executeQuery($delete_telephone);
			$res = $DBmanager->executeQuery($delete_fax);
			$res = $DBmanager->executeQuery($delete_email);
			$res = $DBmanager->executeQuery($delete_note);
			
			$DBmanager->closeDb();
			return $res;
		}
		
		public function getContactList() {
			return $this->ContactList;
		}
		
		public function isContactsEmpty() {
			if($this->ContactList == null) 
				return true;
			return false;
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
		
		//-------------------------------------------------------------------------------

		public function getIsMasterInfoSet() {
			return $this->IsMasterInfoSet;
		}
		
		public function getMasterName() {
			return $this->master_name;
		}
		
		public function getMasterAddress() {
			return $this->master_address ;
		}
		
		public function getMasterTelephone() {
			return $this->master_telephone;
		}
		
		public function getMasterFax() {
			return $this->master_fax;
		}
		
		public function getMasterEmail() {
			return $this->master_email;
		}
		
		public function getMasterNote() {
			return $this->master_note;
		}
		
		//---------------------------------------------------------------------------------------
		
		public function queryMasterInfo() {
			$DBmanager = new DataBaseManager();
			$DBmanager->connectToDB();
			$e_user_id = $DBmanager->real_escape_string($_SESSION['user_id']);
			$e_selected_id = $DBmanager->real_escape_string($_SESSION['selected-id']);
			
			$this->master_name = $this->queryMasterName($DBmanager, $e_user_id, $e_selected_id);
			$this->master_address = $this->queryMasterAddress($DBmanager, $e_user_id, $e_selected_id);
			$this->master_telephone = $this->queryMasterTelephone($DBmanager, $e_user_id, $e_selected_id);
			$this->master_fax = $this->queryMasterFax($DBmanager, $e_user_id, $e_selected_id);
			$this->master_email = $this->queryMasterEmail($DBmanager, $e_user_id, $e_selected_id);
			$this->master_note = $this->queryMasterNote($DBmanager, $e_user_id, $e_selected_id);
			$this->IsMasterInfoSet = TRUE;
			/*var_dump($master_address);
			echo "<br/>";
			var_dump($master_telephone);
			echo "<br/>";
			var_dump($master_fax);
			echo "<br/>";
			var_dump($master_email);
			echo "<br/>";
			var_dump($master_note);
			echo "<br/>";*/

			$DBmanager->closeDb();
		}
		
		private function queryMasterName($DBmanager, $e_user_id, $e_selected_id) {
			$query = "SELECT CONCAT_WS(' ', first_name, last_name) AS display_name FROM master_name WHERE id = '" . $e_selected_id . "' AND user_id = '" . $e_user_id . "'";
			$result = $DBmanager->executeQuery($query);
			$name_info = $result->fetch_assoc();
			return $name_info['display_name'];	
		}
		
		private function queryMasterAddress($DBmanager, $e_user_id, $e_selected_id) {
			$query = "SELECT address, city, province, zipcode, type FROM address WHERE master_id = '" . $e_selected_id . "' AND user_id = '" . $e_user_id . "'";
			$result = $DBmanager->executeQuery($query);
			$res_array = NULL;
			if($result->num_rows > 0) {
				while($add_info = $result->fetch_assoc()) {
					$res_array[] = $add_info;
				}
			}
			return $res_array;
		}
		
		private function queryMasterTelephone($DBmanager, $e_user_id, $e_selected_id) {
			$query = "SELECT tel_number, type FROM telephone WHERE master_id = '" . $e_selected_id . "' AND user_id = '" . $e_user_id . "'";
			$result = $DBmanager->executeQuery($query);
			$res_array = NULL;
			if($result->num_rows > 0) {
				while($add_info = $result->fetch_assoc()) {
					$res_array[] = $add_info;
				}
			}
			return $res_array;
		}
		
		private function queryMasterFax($DBmanager, $e_user_id, $e_selected_id) {
			$query = "SELECT fax_number, type FROM fax WHERE master_id = '" . $e_selected_id . "' AND user_id = '" . $e_user_id . "'";
			$result = $DBmanager->executeQuery($query);
			$res_array = NULL;
			if($result->num_rows > 0) {
				while($add_info = $result->fetch_assoc()) {
					$res_array[] = $add_info;
				}
			}
			return $res_array;
		}
		
		private function queryMasterEmail($DBmanager, $e_user_id, $e_selected_id) {
			$query = "SELECT email, type FROM email WHERE master_id = '" . $e_selected_id . "' AND user_id = '" . $e_user_id . "'";
			$result = $DBmanager->executeQuery($query);
			$res_array = NULL;
			if($result->num_rows > 0) {
				while($add_info = $result->fetch_assoc()) {
					$res_array[] = $add_info;
				}
			}
			return $res_array;
		}
		
		private function queryMasterNote($DBmanager, $e_user_id, $e_selected_id) {
			$query = "SELECT note FROM description WHERE master_id = '" . $e_selected_id . "' AND user_id = '" . $e_user_id . "'";
			$result = $DBmanager->executeQuery($query);
			$res_array = NULL;
			if($result->num_rows > 0) {
				while($add_info = $result->fetch_assoc()) {
					$res_array[] = $add_info;
				}
			}
			return $res_array;
		}
		
	
	}
	
?>