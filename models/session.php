<?php
	class Session {

		public $session_user;

		public function __construct() {
			$session_name = 'sec_session_id'; // Set a custom session name
	        $secure = false; // Set to true if using https.
	        $httponly = true; // This stops javascript being able to access the session id. 
	 
	        ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies. 
	        $cookieParams = session_get_cookie_params(); // Gets current cookies params.
	        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
	        session_name($session_name); // Sets the session name to the one set above.
	        session_start(); // Start the php session
	        session_regenerate_id(true); // regenerated the session, delete the old one.   
		}
 
		public function loginCheck() {
			if(isset($_SESSION['user_id']) && isset($_SESSION['remember_token'])) {
	        	$user = new User();
	        	$user->find($_SESSION['user_id']);
	        	if($user != null && $user->remember_token == $_SESSION['remember_token']) {
	        		$this->session_user = $user;
	   				return true;
	        	}
	        	else {
	        		return false;
	        	}
	        }
	        else {
	        	return false;
	        }
		}

		public function login($form_email, $form_password) {
			if(!isset($_SESSION['user_id'])) {
				$user = new User();
				$message = $user->login($form_email, $form_password);
				if($message  == "SUCCESS") {
					$_SESSION['remember_token'] = $user->getRememberToken();
					$_SESSION['user_id'] = $user->getUserId(); 
					return "SUCCESS";
				}
				else if($message  == "WRONG") {
					return "WRONG";
				}
				else if($message  == "EMAIL") {
					return "EMAIL";
				}
			}
		}

		public function logout() {
			$_SESSION = array();
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
			session_destroy();
		}
		
		public function setSessionVariable($var,$val) {
			$_SESSION[$var] = $val;
		}
		public function getSessionVariable($var) {
			return $_SESSION[$var];
		}
		public function unsetSessionVariable($var) {
			unset($_SESSION[$var]);
		}
		
		public function isSessionVariable($var) {
			if(isset($_SESSION[$var])) {
				return true;
			}
			else {
				return false;
			}
		}
		
		public function setErrorMessage($message) {
			$_SESSION['error'] = $message;
		}
		
		public function getErrorMessage() {
			return $_SESSION['error'];
		}
		
		public function unsetErrorMessage() {
			unset($_SESSION['error']);
		}
		
		public function isError() {
			if(isset($_SESSION['error'])) {
				return true;
			}
			else {
				return false;
			}
		}

		public function getSessionUser() {
			return $this->session_user;
		}

		public function setSessionToken() {
			//$this->session_token = hash('sha512', microtime());
			$session_token = hash('sha256', microtime());
			$_SESSION['session_token'] = $session_token;
			return $session_token;
		}

		public function unsetSessionToken() {
			if(isset($_SESSION['session_token'])) {
				unset($_SESSION['session_token']);
			}
		}

		public function getSessionToken() {
			if(isset($_SESSION['session_token'])) {
				return $_SESSION['session_token'];
			}
		}
	}
?>