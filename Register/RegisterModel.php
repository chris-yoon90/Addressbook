<?php
	class RegisterModel {
		
		private $observers = null;
		private $isEmailValidated = TRUE;
		private $isUsernameValidated = TRUE;
		private $isPasswordValidated = TRUE;
		private $isPasswordConfirmed = TRUE;
		private $style;
		private $title;
		
		public function __construct() {
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
		
		public function registerNewUser() {
			$DBmanager = new DataBaseManager();
			$DBmanager->connectToDB();
			
			$e_first_name = $DBmanager->real_escape_string($_POST['first_name']);
			$e_last_name = $DBmanager->real_escape_string($_POST['last_name']);
			$e_email = $DBmanager->real_escape_string($_POST['email']);
			$e_username = $DBmanager->real_escape_string($_POST['username']);
			$e_password = $DBmanager->real_escape_string($_POST['password']);

			$query = "INSERT INTO users (id, first_name, last_name, email, username, password) 
							VALUES ( 'NULL', '" . $e_first_name . "', '" . $e_last_name . "', '" .$e_email . "', '" . $e_username . "', PASSWORD('" . $e_password . "'));";
		
			//printf($query . "<br />");
			//return true;
			$result = $DBmanager->executeQuery($query);
			$DBmanager->closeDb();
			return $result;
		}
		
		public function validate() {
			
			$this->validateEmail($_POST['email']);
			$this->validateUsername($_POST['username']);
			$this->validatePassword($_POST['password']);
			$this->confirmPassword($_POST['password'], $_POST['confirm_password']);
			
			//printf($this->isPasswordConfirmed);
			
			if($this->isEmailValidated && $this->isUsernameValidated && $this->isPasswordValidated && $this->isPasswordConfirmed)
				return true;
			else return false;
			
		}
	
		public function getEmailValidationStatus() {
			return $this->isEmailValidated;
		}
		
		public function getUsernameValidationStatus() {
			return $this->isUsernameValidated;
		}
		
		public function getPasswordValidationStatus() {
			return $this->isPasswordValidated;
		}
		
		public function getPasswordConfirmValidationStatus() {
			return $this->isPasswordConfirmed;
		}
		
		private function confirmPassword($password, $confirm_password) {
			//printf($password);
			//printf($confirm_password);
			if($this->isPasswordValidated) {
				if (trim($password) !== trim($confirm_password)) {
					$this->isPasswordConfirmed = FALSE;
				} else {
					$this->isPasswordConfirmed = TRUE;
				}
			}
		}
		
		private function validateEmail($email) {
			if((trim($email) === "") || (substr_count(trim($email), "@") !== 1)) {
				$this->isEmailValidated = FALSE;
			} else {
				$this->isEmailValidated = TRUE;
			}
		}
		
		private function validateUsername($username) {
			if(trim($username) === "" ) {
				$this->isUsernameValidated = FALSE;
			} else {
				$this->isUsernameValidated = TRUE;
			}
		}
		
		private function validatePassword($password) {
			if(trim($password) === "") {
				$this->isPasswordValidated = FALSE;
			} else {
				$this->isPasswordValidated = TRUE;
			}
		}
		
		
		
		
		
	
	}

?>