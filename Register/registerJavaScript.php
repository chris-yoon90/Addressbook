<?php
	require_once('../utility/DataBaseLibrary.php');
	require_once('../utility/SessionManager.php');
	require_once('RegisterModel.php');
	
	SessionManager::sessionStart("user");
	
	$model = new RegisterModel();

	if($_POST) {
		if($model->registerNewUser()) {
			echo "success";
		} else {
			echo "failed";
		}
	}
	

?>