<?php
class LoginView {
		
		
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
		<link rel='stylesheet' type="text/css" href='Libraries/bootstrap/css/bootstrap-responsive.css' />
		<link rel="stylesheet" type="text/css" href="$style" />
		<link rel="stylesheet" type="text/css" href="Libraries/bootstrap/css/bootstrap.css" />
	</head>
	<body>	
CONTENT;

			if( ($model->getLogInStatus() !== null) && !$model->getLogInStatus()) {				
				echo <<<CONTENT
		<div id='loginError' class='alert alert-error' style='width :40%; margin: 0 auto;'>
			<a id='error-message' class='close' data-dismiss='alert'>x</a>
			Login failed. Either your user name or password is wrong. 
		</div>
CONTENT;
			}
			
			echo <<<CONTENT
		<div id="login-form-box" class="container">
			<form id="login-form" method="POST" action="$_SERVER[PHP_SELF]">
				<h2>Log In</h2>
				<div class="control-group">
					<div class="controls">
						<input form="login-form" type="text" id="userID" name="userID" placeholder="Username" />
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input form="login-form" type="password" id="user_password" name="user_password" placeholder="Password" />
					</div>
				</div>
				
				<div class="control-group">
					<p class="help-block">
						<a href= "Register/register.php">Register</a>
					</p>
					<div class="controls">
						<button class="btn btn-large btn-primary" form="login-form" type="submit" name="submit" value="LogIn">Log in</button>
					</div>
				</div>
			</form>
		</div>	
		<div id="footer">Copyright &copy; <script language="JavaScript" type="text/javascript">
			document.write(document.lastModified); </script>
		</div>
		
		<script src="Libraries/dojo/dojo.js" data-dojo-config="async: true, isDebug: true"></script>
		<script src="index.js"></script>

	</body>
</html>		
			
			
CONTENT;
		}
		
	}
?>