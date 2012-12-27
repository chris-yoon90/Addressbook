<?php
	require_once('utility/DataBaseLibrary.php');
	require_once('utility/SessionManager.php');
	require_once('LoginModel.php');
	require_once('LoginView.php');
	require_once('LoginControl.php');
	
	SessionManager::sessionStart("user");
	//echo session_id() . "<br/>";
	$view = new LoginView();
	$model = new LoginModel();
	$model->attachViews($view);	
	$model->setTitle("Log In");
	$model->setStyleSheet("css/title.css");
	
	$control = new LoginControl($model);
	$control->Run();

?>