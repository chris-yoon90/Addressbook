<?php
	class RegisterControl {
		
		private $model;
		
		public function __construct($model) {
			$this->model = $model;

		}
		
		public function Run() {
			if($_POST) {
				//var_dump($_POST);
				if(isset($_POST['cancel'])) {
					
					header("Location: ../index.php");
					exit();
				}
				if($this->model->validate()) {
					//printf("validation true <br/>");
					$res = $this->model->registerNewUser();
					if($res) {
						//TODO: Put an indication where the user is being redirected to login page------------
						header("Location: ../index.php");
						//printf("Success");
						exit();
					} else {
						echo "Query to the database failed.";
					}
				} else {
					//printf("validation failed");
				}
			}
			
			$this->model->notifyViews();
		}
		
		
		
	}

?>