<?php
	require_once('../../utility/DataBaseLibrary.php');
	require_once('../../utility/SessionManager.php');
	require_once('AddEntryControl.php');
	require_once('AddEntryView.php');
	require_once('AddEntryModel.php');
	
	SessionManager::sessionStart("user");
	//echo session_id() . "<br/>";
	SessionManager::regenerateSession();
	//echo session_id() . "<br/>";
	
	$view = new AddEntryView();
	$model = new AddEntryModel();
	$model->attachViews($view);
	$model->setTitle("Add Entry");
	$model->setStyleSheet("../../css/title.css");
	
	$control = new AddEntryControl($model, $view);
	$control->Run();
	
?>