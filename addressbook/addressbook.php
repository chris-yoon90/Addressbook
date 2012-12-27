<?php
	require_once('../utility/DataBaseLibrary.php');
	require_once('../utility/SessionManager.php');
	require_once('AddressbookControl.php');
	require_once('AddressbookModel.php');
	require_once('AddressbookView.php');
	
	//session_start();
	SessionManager::sessionStart("user");
	//echo session_id() . "<br/>";
	SessionManager::regenerateSession();
	//echo session_id() . "<br/>";
	$view = new AddressbookView();
	$model = new AddressbookModel();
	$model->attachViews($view);	
	$model->setTitle("Address Book: View Address");
	$model->setStyleSheet("../css/title.css");
	
	$control = new AddressbookControl($model);
	$control->Run();

?>