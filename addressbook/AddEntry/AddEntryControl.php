<?php
	
	class AddEntryControl {
		
		private $model;
		
		public function __construct($model) {
			$this->model = $model;
		}
		
		public function Run() {
			if($_POST) {
				if(isset($_POST['cancel']) && $_POST['cancel'] == "cancel") {
					header("Location: ../addressbook.php");
					exit();
				}
				
				if($_POST['first_name'] == "" || $_POST['last_name'] == "") {
					header("Location: AddEntry.php");
					exit();
				} 
				if($this->model->validateData()) {
					$this->model->addToDatabase();
					header("Location: ../addressbook.php");
					exit();
				} else {
					//TODO: if data is not validated, display error
				}
			}
			
			$this->model->notifyViews();
		}
		
		
		
		
	}
	
?>