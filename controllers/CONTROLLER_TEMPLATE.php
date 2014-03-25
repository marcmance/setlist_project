<?php

	/*REMEMBER:
		ADD TO ROUTER
	*/

	class newController extends Controller {

		public function __construct() {
			parent::__construct();
		}
		
		public function index() {
			if(isset($this->urlParams['id'])) {
				$this->model = new Whatever();
			}
			else { 
				$this->validId = false;
				$this->pageTitle = "Invalid profile";
			}
		}
	}
?>