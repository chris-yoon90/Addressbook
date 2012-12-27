<?php
	require_once('../DataBaseLibrary.php');
	require_once('../SessionManager.php');
	require_once('AddressbookModel.php');
	
	SessionManager::sessionStart("user");
	
	$model = new AddressbookModel();
	$_SESSION['selected-id'] = $_POST['select-record'];
	
	$model->deleteContact();
	$model->setContactList();
	echo "FINISH!";

?>