<?php

	class AddressbookView {
		
		public function __construct() {
		}
		
		public function buildPage($model) {
			$title = $model->getTitle();
			$style = $model->getStyleSheet();
			
			//$this->addHeader($title, $style);
			echo <<<CONTENT
<!DOCTYPE html>
<html>
	<head>
		<title>$title</title>
		<meta name='viewport' content='width=device-width, initial-scale=1.0'/>
		<link rel='stylesheet' type="text/css" href='../Libraries/bootstrap/css/bootstrap-responsive.css' />
		<link rel="stylesheet" type="text/css" href="../Libraries/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="$style" />
	</head>
	<body>
	<div class = "container-fluid">
		<div class="row-fluid">
			<div class='navbar'>
				<div class="span11">
					<h1>My Address Book</h1>
				</div>
				<div class="span1">
					<form id="log-out" method="POST" action="$_SERVER[PHP_SELF]"> 
						<button class="btn btn-mini btn-primary" form="log-out" type="submit" name="log-out" value="log-out">Logout</button>
					</form>
				</div>
			</div>
		</div>
		<div class='row-fluid' style='padding-top: 25px'>
			<div id='span3' class='span3'>
				<div class='well sidebar-nav'>
				<ul>
					<li><a href='AddEntry/AddEntry.php'>Add an Entry</a></li>
				</ul>		
CONTENT;

			//build navigation bar
			$this->displayContacts($model->getContactList());
			if($model->isContactsEmpty()) {
				$this->displayNoContact();
			}
			
			echo <<<CONTENT
				</div>
			</div>
			<div id='span8' class='span8'>
				<div id='detail-view' class='hero-unit'>
CONTENT;
			
			//build main content
			if(!$model->getIsMasterInfoSet()) {
				echo "<h2>Select an entry to view contacts.</h2>";
			} else {
			//display details if selected
				$this->printName($model->getMasterName());
				$this->printAddress($model->getMasterAddress());
				$this->printTelephone($model->getMasterTelephone());
				$this->printFax($model->getMasterFax());
				$this->printEmail($model->getMasterEmail());
				$this->printNote($model->getMasterNote());
			}

			echo <<<CONTENT
				</div>
			</div>
		</div>
	</div>
	<script src="../Libraries/dojo/dojo.js" data-dojo-config="async: true, isDebug: true"></script>
	<script src="addressbook.js" ></script>
	</body>
</html>	
CONTENT;
			
		}
		
		//-------------------------------------------------------------------------
		
		private function displayNoContact() {
			echo <<<CONTENT
			<div>No records found. Click Add Entry to add a contact.</div>
			
CONTENT;
		}
		
		private function displayContacts($contacts) {
			echo <<<CONTENT
			<div id="record-block" style='padding-top: 25px;'>
				<form id="view-form" method="POST" action="$_SERVER[PHP_SELF]" >
					<div class='control-group'>
						<div class='controls'>
							<button id='view-button' class='btn btn-mini' form="view-form" type="submit" name="submit" value="view">View Selected Entry</button>
							<button id='del-button' class='btn btn-mini' form="view-form" type="submit" name="submit" value="delete">Delete Selected Entry</button>
						</div>

					</div>
					<div class='control-group'>
						<label class='control-label' for="select-record">Select a Record</label>
						<div class='controls'>
							<select form="view-form" id="select-record" name="select-record" required="required">
								<option class='rec' value="default">--Select One--</option>
CONTENT;
			
			foreach($contacts as $recs) {
				$id = stripslashes($recs['id']);
				$display_name = stripslashes($recs['display_name']);
				echo "<option value='".$id."' >" . $display_name . "</option>";
			}
			
			echo <<<CONTENT
							</select>
						</div>
					</div>
				</form>
			</div>
CONTENT;
		}
		
		private function printName($master_name) {
			$name = stripslashes($master_name);
			echo "<h2> Contact Detail for " . $name . "</h2>";
		}
		
		private function printAddress($master_address) {
			echo "<fieldset><legend>Addresses:</legend> <ul>";
			if($master_address !=null) {
				foreach($master_address as $value) {
					$address = stripslashes($value['address']);
					$city = stripslashes($value['city']);
					$province = stripslashes($value['province']);
					$zipcode = stripslashes($value['zipcode']);
					$add_type = stripslashes($value['type']);
				
					echo "<li>$address $city $province $zipcode ($add_type)</li> ";
				}
			}
			
				echo "</ul></fieldset>";
		}
		
		private function printTelephone($master_telephone) {
			echo "<fieldset><legend>Telephones:</legend> <ul>";
			if($master_telephone !=null) {
				foreach($master_telephone as $value) {
					$tel_number = stripslashes($value['tel_number']);
					$tel_type = stripslashes($value['type']);
				
					echo "<li>$tel_number ($tel_type)</li> ";
				}
			}
			echo "</ul></fieldset>";
		}
		
		private function printFax($master_fax) {
			echo "<fieldset><legend>Fax:</legend> <ul>";
			if($master_fax !=null) {
				foreach($master_fax as $value) {
					$fax_number = stripslashes($value['fax_number']);
					$fax_type = stripslashes($value['type']);
				
					echo "<li>$fax_number ($fax_type)</li> ";
				}
			}	
			echo "</ul></fieldset>";
		}
		
		private function printEmail($master_email) {
			echo "<fieldset><legend>Email:</legend> <ul>";
			if($master_email !=null) {
				foreach($master_email as $value) {
					$email = stripslashes($value['email']);
					$email_type = stripslashes($value['type']);
				
					echo "<li>$email ($email_type)</li> ";
				}
			}
				echo "</ul></fieldset>";
		}
		
		private function printNote($master_note) {
			echo "<fieldset><legend>Note:</legend> ";
			if($master_note !=null) {
				foreach($master_note as $value) {
					$note = stripslashes($value['note']);
								
					echo "$note";
				}
			}
			echo "</fieldset>";
		}
	
	}
?>