<?php
	require_once('utility/DataBaseLibrary.php');
	require_once('utility/SessionManager.php');
	require_once('LoginModel.php');
	
	SessionManager::sessionStart("user");
	//echo session_id() . "<br/>";

	$model = new LoginModel();
	
	if($_POST) {
		
		
		if($model->validateUserInfo()) {
			echo json_encode("true");
		} else {
			echo json_encode("false");
		}
	}
	
?>