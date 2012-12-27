<?php
	require_once('../utility/DataBaseLibrary.php');
	require_once('../utility/SessionManager.php');
	require_once('AddressbookModel.php');
	
	SessionManager::sessionStart("user");
		
	$model = new AddressbookModel();

	if($_POST) {

			$_SESSION['selected-id'] = $_POST['select-record'];
			//var_dump($_SESSION);
			$model->queryMasterInfo();
			$result = array (
					//name is a string
					"name" => $model->getMasterName(),
					//The rest of the info are array of arrays. ex> $model->getMasterAddress() returns arrays of address info
					//since there may be multiple addresses for one contact.
					"addressInfo" => $model->getMasterAddress(),
					"telInfo" => $model->getMasterTelephone(),
					"faxInfo" => $model->getMasterFax(),
					"emailInfo" => $model->getMasterEmail(),
					"noteInfo" => $model->getMasterNote()
					);
					
			echo json_encode($result);
			//var_dump($result);
		
			
	}
	
	
?>