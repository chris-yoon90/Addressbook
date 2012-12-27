<?php
	class RegisterView {
	
		public function __construct() {
		
		}
	
		public function buildPage($model) {
			$title = $model->getTitle();
			$style = $model->getStyleSheet();

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
		<h2 id='register_title'>New User Registration</h2>
		<fieldset> 
			<form class="form-horizontal" id="register-form" method="POST" action="$_SERVER[PHP_SELF]">
				<div id='first_name_container' class="control-group">
					<label class="control-label" for="first_name">First Name: </label>
					<div class="controls">
						<input form="register-form" type="text" id="first_name" name="first_name" size="40" maxlength="30" placeholder="First Name" required="required" /> 
						<!--<span class="help-inline" style='color: #FF0000'>TEST</span>-->
					</div>
				</div>
				
				<div id = 'last_name_container' class="control-group">
					<label class="control-label" for="last_name">Last Name: </label> 
					<div class="controls">
						<input form="register-form" type="text" id="last_name" name="last_name" size="40" maxlength="30" placeholder="Last Name" required="required" /> 
					</div>
				</div>
CONTENT;
				
			if(!$model->getEmailValidationStatus()) {
				echo "<div class='alert alert-error' >
						<a class='close' data-dismiss='alert'>x</a>
							Email validation failed! 
						</div>";
			}
			
			echo <<<CONTENT
				<div id='email_container' class="control-group">
					<label class="control-label" for="email">Email: </label> 
					<div class="controls">
						<input form="register-form" type="email" id="email" name="email" size="40" maxlength="30" placeholder="Email"  /> 
					</div>
				</div>
CONTENT;
			
			if(!$model->getUsernameValidationStatus()) {
				echo "<div class='alert alert-error'>
					<a class='close' data-dismiss='alert'>x</a>
					Username validation failed: 
				</div>";
			}
			
			echo <<<CONTENT
				<div id='username_container' class="control-group">
					<label class="control-label" for="username">User Name: </label> 
					<div class="controls">
						<input form="register-form" type="text" id="username" name="username" size="40" maxlength="30" placeholder="User Name"  />
					</div>
				</div>
CONTENT;
			
			if(!$model->getPasswordValidationStatus()) {
				echo "<div class='alert alert-error'>
					<a class='close' data-dismiss='alert'>x</a>
					Password validation failed! 
				</div>";
			}
			
			if(!$model->getPasswordConfirmValidationStatus()) {
				echo "<div class='alert alert-error'>
					<a class='close' data-dismiss='alert'>x</a>
					Password confirmation failed! 
				</div>";
			}
		
			echo <<<CONTENT
				<div id='password_container' class="control-group">
					<label class="control-label" for="password">Password </label> 
					<div class="controls">
						<input form="register-form" type="password" id="password" name="password" size="40" maxlength="30" placeholder="Password"  /> 
					</div>
					<div class="controls">
						<input form="register-form" type="password" id="confirm_password" name="confirm_password" size="40" maxlength="30" placeholder="Confirm password"  />
					</div>
				</div>
				
				<div class="form-actions" style="background-color: transparent;">
					<button class="btn btn-primary" form="register-form" type="submit" name="submit" value="register">Register</button>
					<button class="btn" form="cancel-form" type="submit" name="cancel" value="cancel">Cancel</button>
				</div>
			</form>
			<form class="form-horizontal" id="cancel-form" method="POST" action="$_SERVER[PHP_SELF]"></form>
			
		</fieldset>
		<script src="../Libraries/dojo/dojo.js" data-dojo-config="async: true, isDebug: true"></script>
		<script src="register.js"></script>
	</body>
</html>	
CONTENT;

		}

	
	}

?>