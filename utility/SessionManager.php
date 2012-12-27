<?php
	//This code was from www.blog.teamtreehouse.com/how-to-create-bulletproof-sessions
	class SessionManager {
		
		static public function sessionStart($name) {
			// Set the cookie name before starting
			session_name($name . "_Session");
			session_start();
			
			if(!self::preventHijacking()) {
				$_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
				//echo "Hijack prevent <br/>";
			}
		
		}
		
		static protected function preventHijacking() {
			
			if(!isset($_SESSION['userAgent'])) {
				return false;
			}
			if ($_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT'])
				return false;
			
			return true;
			
		}
		
		static public function regenerateSession() {
			$old_SESSION = $_SESSION;
			session_regenerate_id(true);
			
		}
		
		static public function destroy() {
			
			session_destroy();
		}
		
		
	
	}


?>