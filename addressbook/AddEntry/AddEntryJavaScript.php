<?php
	require_once('../../utility/DataBaseLibrary.php');
	require_once('../../utility/SessionManager.php');
	require_once('AddEntryModel.php');
	
	SessionManager::sessionStart("user");
	
	$model = new AddEntryModel();
	
	if($_POST) {
	//var_dump($_POST);
		if($model-> addToDatabase()) {
			echo "success";
		} else {
			echo "failed";
		}
		
	}
	
	

?>