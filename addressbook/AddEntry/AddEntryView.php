<?php
	
	class AddEntryView {
			public function __construct() {}
		
		public function buildPage($model) {
			$title = $model->getTitle();
			$style = $model->getStyleSheet();
			
			echo <<<CONTENT
<!DOCTYPE html>	
<html>
	<head>
		<title>$title</title>
		<meta name='viewport' content='width=device-width, initial-scale=1.0'/>
		<link rel='stylesheet' type="text/css" href='../../Libraries/bootstrap/css/bootstrap-responsive.css' />
		<link rel="stylesheet" type="text/css" href="$style" />
		<link rel='stylesheet' type='text/css' href='../../Libraries/bootstrap/css/bootstrap.css'/>
	</head>
	<body>
			<div id="add-entry-form-box">
				<form id="cancel-entry-form" method="POST" action="$_SERVER[PHP_SELF]"></form>
				<form id="add-entry-form" class='well' method="POST" action="$_SERVER[PHP_SELF]">
				<fieldset>
						<legend>First/Last Names:</legend>
					<div class='control-group'>
						<div class='controls'>
							<input form="add-entry-form" type="text" id='first_name' name="first_name" size="30" maxlength="75" required="required" value placeholder="First Name" />
							<input form="add-entry-form" type="text" id='last_name' name="last_name" size="30" maxlength="75" required="required" value placeholder="Last Name" />
						</div>
					</div>
				</fieldset>
				
				<fieldset>
					<legend>Address</legend>
					<div class='control-group'>
						<label class='control-label' for="street-address">Street Address:</label>
						<div class='controls'>
							<input form="add-entry-form" type="text" id="address" name="address" size="30" value placeholder="Street Address"/>
						</div>
					</div>
					<div class='control-group'>
						<label class='control-label'>City/Province</label>
						<div class='controls'>
							<input form="add-entry-form" type="text" id="city" name="city" size="30" maxlength="50" value placeholder="City"/>
							<select form="add-entry-form" id='province' name="province" required="required">
								<option value="default">--Select Province--</option>
								<option value="AB">Alberta</option>
								<option value="BC">British Columbia</option>
								<option value="MB">Manitoba</option>
								<option value="NB">New Brunswick</option>
								<option value="NL">Newfoundland and Labrador</option>
								<option value="NT">Northwest Territories</option>
								<option value="NS">Nova Scotia</option>
								<option value="NU">Nunavut</option>
								<option value="ON">Ontario</option>
								<option value="PE">Prince Edward Island</option>
								<option value="QC">Quebec</option>
								<option value="SK">Saskatchewan</option>
								<option value="YT">Yukon</option>
							</select>
						</div>
					</div>
					<div class='control-group'>
						<label class='control-label' for="zipcode">Postal Code:</label>
						<div class='controls'>
							<input form="add-entry-form" type="text" id="zipcode" name="zipcode" size="10" maxlength="10" value placeholder="Postal code"/>
						</div>
					</div>
					<div class='control-group'>
						<div class='controls'>
							<label class='radio inline' for="add-typw-h">
								<input form="add-entry-form" type="radio" id="add_type_h" name="add_type" value="home" checked /> 
								home
							</label>
							<label class='radio inline' for="add-type-w">
								<input form="add-entry-form" type="radio" id="add_type_w" name="add_type" value="work" />
								work
							</label>
							<label class='radio inline' for="add-typ-o">
								<input form="add-entry-form" type="radio" id="add_type_o" name="add_type" value="other"/>
								other
							</label>
						</div>
					</div>
				</fieldset>
				
				<fieldset>
					<legend>Telephone Number:</legend>
					<div class='control-group'>
						<div class='controls'>
						<input form="add-entry-form" type="text" id='tel_number' name="tel_number" size="30" maxlength="25" value placeholder="Telephone"/>
						</div>
					</div>
					<div class='control-group'>
						<div = class='controls'>
							<label class='radio inline' for="tel-type-h">
								<input form="add-entry-form" type="radio" id="tel_type-h" name="tel_type" value="home" checked/>
								home
							</label>
							<label class='radio inline' for="tel-type-w">
								<input form="add-entry-form" type="radio" id="tel_type_w" name="tel_type" value="work"/>
								work
							</label>
							<label class='radio inline' for="tel-type-o">
								<input form="add-entry-form" type="radio" id="tel_type_o" name="tel_type" value="other"/>
								other
							</label>
						</div>
					</div>
				</fieldset>
				
				<fieldset>
					<legend>Fax Number:</legend>
					<div class='control-group'>
						<div class='controls'>
							<input form="add-entry-form" type="text" id='fax_number' name="fax_number" size="30" maxlength="25" value placeholder="Fax Number" />
						</div>
					</div>
					<div class='control-group'>
						<div class='controls'>
							<label class='radio inline' for="fax-type-h">
								<input form="add-entry-form" type="radio" id="fax_type_h" name="fax_type" value="home" checked/>
								home
							</label>
							<label class='radio inline' for="fax-type-w">
								<input form="add-entry-form" type="radio" id="fax_type_w" name="fax_type" value="work"/>
								work
							</label>
							<label class='radio inline' for="fax-type-o">
								<input form="add-entry-form" type="radio" id="fax_type_o" name="fax_type" value="other"/>
								other
							</label>
						</div>
					</div>
				</fieldset>
				
				<fieldset>
					<legend>Email:</legend>
					<div class='control-group'>
						<div class='controls'>
							<input form="add-entry-form" type="email" id='email' name="email" size="40" maxlength="30" value placeholder="Email"/>
						</div>
					</div>
					<div class='control-group'>
						<div class='controls'>
							<label class='radio inline' for="email-type-h">
								<input form="add-entry-form" type="radio" id="email_type_p" name="email_type" value="personal" checked/>
								personal
							</label>
							<label class='radio inline' for="email-type-w">
								<input form="add-entry-form" type="radio" id="email_type_w" name="email_type" value="work"/>
								work
							</label>
						</div>
					</div>
				</fieldset>
				
				<fieldset>
					<legend>Note:</legend>
					<div class='control-groups'>
						<div class='controls'>
							<textarea form="add-entry-form" id="note" name="note" cols="35" rows="3"></textarea>
						</div>
					</div>
				</fieldset>
				
				<div class='form-actions'>
					<button form='add-entry-form' type="submit" name="submit" value="send">Add Entry</button>
					<button form='cancel-entry-form' type="submit" name="cancel" value="cancel">Cancel</button>
				</div>
				
				</form>
				
			</div>
		<script src="../../Libraries/dojo/dojo.js" data-dojo-config="async: true, isDebug: true"></script>
		<script src="AddEntry.js" ></script>
	</body>
</html>
			
CONTENT;
			
		}
	
	
	}

?>