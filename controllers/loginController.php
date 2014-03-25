<?php
	class loginController extends Controller {
	
		public $loginEmail;
		public function __construct() {
			parent::__construct();
		}
		
		public function index() {
			if($this->loggedIn) {
				$this->redirect("/dashboard");
				//echo "<b>Remember TOKEN: </b>".$_SESSION['remember_token'] ."<br/>";
			}
			else {
				$this->pageTitle = "Setlist Login";
				if($this->s->isSessionVariable("loginEmail")) {
					$this->loginEmail = $this->s->getSessionVariable("loginEmail");
					$this->s->unsetSessionVariable("loginEmail");
				}
				else {
					$this->loginEmail = "";
				}
			}
		}
		public function login() {
			if($this->ifPost()) {
				$login_email = $_POST['login_email'];
				$login_password = $_POST['login_password'];
				$login_message = $this->s->login($login_email, $login_password);
				if($login_message == "SUCCESS") {
					$this->redirect("/dashboard");
				}
				else {
					$this->s->setSessionVariable("loginEmail",$login_email);
					$this->s->setErrorMessage("Wrong password or email.");
					$this->redirect("/login");
				}
			}
		}
		public function logout() {
			$this->s->logout();	
			$this->redirect("/login");			
		}
	}
	

?>