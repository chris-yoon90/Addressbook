<?php
	require_once('../utility/DataBaseLibrary.php');
	require_once('../utility/SessionManager.php');
	require_once('AddressbookModel.php');
	
	SessionManager::sessionStart("user");
	
	$model = new AddressbookModel();
	
	if($_POST) {
		//var_dump($_POST);
		if($_POST['select-record'] !== "default") {
			$_SESSION['selected-id'] = $_POST['select-record'];
			$DBmanager = new DataBaseManager();
			$DBmanager->connectToDB('localhost','chris','12345678','testdatabase');
		
			$result = null;
			if(deleteContact($DBmanager)) {
				$result = array (
					"status" => "success",
					//"contact_info" => getContactList($DBmanager)
					);
			} else {
				$result = array (
					"status" => "failed",
					//"contact_info" => getContactList($DBmanager)
					);
			}

		$result["contact_info"] = getContactList($DBmanager);
			
			//var_dump($result);
		$DBmanager->closeDb();
		
		} else {
			$result = array (
					"status" => "default"
				);
		}

		echo json_encode($result);
		
	}
	
	function getContactList($DBmanager) {
		$e_user_id = $DBmanager->real_escape_string($_SESSION['user_id']);
		$query = "SELECT id, CONCAT_WS(' ', first_name, last_name) AS display_name FROM master_name WHERE user_id='".$e_user_id. "' ORDER BY first_name, last_name ";
			
		$result = $DBmanager->executeQuery($query);

		if($result->num_rows > 0) {
				$res_array = null;
				while($recs = $result->fetch_assoc()) {
					$res_array[] = $recs;
				}
				return $res_array;
		} else {
			return null;
		}
	}
	
	function deleteContact($DBmanager) {
		$e_user_id = $DBmanager->real_escape_string($_SESSION['user_id']);
		$e_selected_id = $DBmanager->real_escape_string($_SESSION['selected-id']);
			
		$delete_master = "DELETE FROM master_name WHERE id = '" . $e_selected_id . "' AND user_id = '" . $e_user_id . "'";
		$delete_address = "DELETE FROM address WHERE master_id = '" . $e_selected_id . "' AND user_id = '" . $e_user_id . "'";
		$delete_telephone = "DELETE FROM telephone WHERE master_id = '" . $e_selected_id . "' AND user_id = '" . $e_user_id . "'";
		$delete_fax = "DELETE FROM fax WHERE master_id = '" . $e_selected_id . "' AND user_id = '" . $e_user_id . "'";
		$delete_email = "DELETE FROM email WHERE master_id = '" . $e_selected_id . "' AND user_id = '" . $e_user_id . "'";
		$delete_note = "DELETE FROM description WHERE master_id = '" . $e_selected_id . "' AND user_id = '" . $e_user_id . "'";
			
		$res = $DBmanager->executeQuery($delete_master);
		$res = $DBmanager->executeQuery($delete_address);
		$res = $DBmanager->executeQuery($delete_telephone);
		$res = $DBmanager->executeQuery($delete_fax);
		$res = $DBmanager->executeQuery($delete_email);
		$res = $DBmanager->executeQuery($delete_note);
			
		return $res;
	}
	

?>