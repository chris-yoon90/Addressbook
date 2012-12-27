<?php
	class LoginControl {
	
		private $model;
	
		public function __construct($model) {
			$this->model = $model;

		}
		
		public function Run() {
			if($_POST) {
				if($this->model->validateUserinfo()) {
					$this->model->setLogInStatus(true);
					header('Location: addressbook/addressbook.php');
					exit();
						
				} else {
					$this->model->setLogInStatus(false);
				}
			} 
			//var_dump($this->model->getLoginStatus());
			$this->model->notifyViews();
			
		}
	
	}
	

?>