<?php
	require_once('../utility/DataBaseLibrary.php');
	require_once('../utility/SessionManager.php');
	require_once('RegisterModel.php');
	require_once('RegisterView.php');
	require_once('RegisterControl.php');
	
	SessionManager::sessionStart("user");
	
	$view = new RegisterView();
	$model = new RegisterModel();
	$model->attachViews($view);	
	$model->setTitle("Register");
	$model->setStyleSheet("../css/title.css");
	
	$control = new RegisterControl($model);
	
	$control->Run();
	
?>