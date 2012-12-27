<?php

	class AddressbookControl {
	
		private $model;
		
		public function __construct($model) {
			$this->model = $model;
		}
		
		public function Run() {
			//show view
			//var_dump($_SESSION);
				
			if(!$_POST) {
				
				//printf($_SESSION['user_id']);
			} else {
				$_SESSION['selected-id'] = $_POST['select-record'];
				
				if($_POST['select-record'] == "default") {
					//re-direct to 
					header("Location: addressbook.php");
					exit();
				} else
				if($_POST['select-record'] != "default" && $_POST['submit'] == "view") {
				//var_dump($_POST);
				//header("Location: DetailView/detailView.php");
				//exit();
				$this->model->queryMasterInfo();
				} else 
				if($_POST['select-record'] != "default" && $_POST['submit'] == "delete") {
					//var_dump($_POST);
					$this->model->deleteContact();
				} else 
				if(isset($_POST['log-out']) && $_POST['log-out'] == "log-out") {
					SessionManager::destroy();
					header('Location: ../index.php');
					exit();
				}
			}
			$this->model->setContactList();
			$this->model->notifyViews();
			
		}
		
		
		//--------------------------------------------------------------------------------------------------------
		
	
	}

?>