<?php
class LoginModel {
		
		private $observers = null;
		private $isLogInSuccess = null;
		private $style = null;
		private $title = null;
		
		public function __construct() {
		}
		
		public function attachViews(/*any number of observers*/) {
			if(func_num_args() === 0) {
				$this->observers == null;
			} else {
				$this->observers = func_get_args();
			}
		}
		
		public function notifyViews() {
			//var_dump($this->observers);
			if($this->observers !== null) {
				foreach ($this->observers as $o) {
					$o->buildPage($this);
				}
			}
		}
		
		public function getLogInStatus() {
			return $this->isLogInSuccess;
		}
		
		public function setLogInStatus($status) {
			$this->isLogInSuccess = $status;
		}
		
		public function validateUserinfo() {
			$DBmanager = new DataBaseManager();
			$DBmanager->connectToDB();
		
			$registered_user = $DBmanager->real_escape_string($_POST["userID"]);
			$user_password = $DBmanager->real_escape_string($_POST["user_password"]);

			$query = "SELECT id, first_name, last_name, email FROM users WHERE username = '" . $registered_user . "' " . "AND password = PASSWORD('" . $user_password . "')";
			//echo $query . "<br />";
		
			$res = $DBmanager->executeQuery($query);
			$DBmanager->closeDb();
			
			if ($res->num_rows === 1) {
				$user_info = $res->fetch_array();
				$_SESSION['user_id'] = $user_info['id'];
				return true;
			} else {
				return false;
			}	
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
		
	}

?>