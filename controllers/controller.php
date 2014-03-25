<?php
	class Controller {
		protected $s; //session
		public $s_user; //session user
		public $loggedIn; //cached boolean
		public $isError; //cached boolean
		public $pageTitle; //page title
		public $model; //
		
		public $validId; //boolean for controllers looking for IDs
		public $urlParams; //array to hold URL params


		public $urlPaths;
		
		public function __construct() {
			$this->s = new Session();
			if($this->s->loginCheck()) {
				$this->s_user = $this->s->session_user;
				$this->loggedIn = true;
			}
			else {
				$this->loggedIn = false;
			}
			$this->isError = $this->s->isError();
			
			//default title.
			$this->pageTitle = "Hello world!";
			$this->urlParams = array();
			$this->urlPaths = array();
		}

		//public 

		public function urlLink($url, $text, $class = null) {
			if($class == null) {
				$url_html = "<a href='". $url ."'>" .$text . "</a>";
			}
			else {
				$url_html = "<a class='". $class ."' href='". $url ."'>" .$text . "</a>";
			}

			return $url_html;
		}

		protected function generateUrlPaths() {
			$relflection = new ReflectionClass(get_class($this));
			foreach ($relflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
				if($method->class == get_class($this) && !$method->isConstructor() && !$method->isDestructor()) {
					echoPretty($method->name);
				}
			}
		}
		
		public function ifPost() {
			if (!empty($_POST)) {
				return true;
			}
			else {
				return false;
			}
		}
		
		public function getErrorMessage() {
			return $this->s->getErrorMessage();
		}
		
		public function unsetErrorMessage() {
			$this->s->unsetErrorMessage();
		}
		
		public function __destruct(){

		}
		
		public function redirect($path) {
			header("Location: " . $path);
			die();
		}
	}
?>