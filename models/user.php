<?php
	class User extends Model {
	
		public $salt;
		public $remember_token;
		public $user_id;

		public function __construct() {
			$this->fields_array = array(
							"user_id",
							"user_first_name",
							"user_last_name",
							"user_type",
							"salt",
							"remember_token",
							"user_email",
							"password",
							"username"
							);
			parent::__construct();	
		}
		
		private function updateRememberToken() {
			$query = "UPDATE user
						SET remember_token = '" . $this->remember_token
						. "' WHERE user_id = " . $this->user_id;
			$result = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			
		}

		/*
			SUCCESS, WRONG, EMAIL
		*/
		public function login($form_email, $form_password) {
			if(!isset($_SESSION['user_id'])) {
				$query = "SELECT user_id, user_email, password, salt, remember_token, username
							FROM user 
							WHERE user_email = ?
							LIMIT 1";

				if ($stmt = $this->mysqli->prepare($query)) { 
					$stmt->bind_param('s', $form_email); // Bind "$email" to parameter.
					$stmt->execute(); // Execute the prepared query.
					$stmt->store_result();

					if($stmt->num_rows == 1) { 
						$stmt->bind_result($user_id, $user_email, $password, $salt, $remember_token, $username); 
						$stmt->fetch();
						$form_password = hash('sha256', $form_password.$salt); 
						$this->user_id = $user_id;
						$this->salt = $salt;
						
						//echo "<br/><b>PASSWORD: </b>".$password."<br/>";
						if($password == $form_password) {
							//after each login generate new remember token
							$this->generateRememberToken();
							//To do: update query with new remember_token
							$this->updateRememberToken();
							//echo "<b>RT: " .$this->remember_token."</b><br/>";
							return "SUCCESS";   
						}
						else {
							//echo wrong password
							//brute force error
							return "WRONG";
						} 
					} 
					else {
						//user email does not exist
						return "EMAIL";
					}
				}
				else {
					//echo mysqli error
				}
			}
		}

		public function isAdmin() {
			return $this->user_type == "admin" ? true : false;
		}

		public function getFullName() {
			return $this->user_first_name . " " . $this->user_last_name;
		}

		public function getRememberToken() {
			return $this->remember_token;
		}
		
		public function getUserId() {
			return $this->user_id;
		}
		
		private function generateRememberToken(){
			$this->remember_token = hash('sha256', $this->salt.microtime());
		}

		private function generateSalt() {
			$this->salt = hash('sha256', microtime());
		}
		
	}
?>