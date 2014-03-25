<?php
	class artistController extends Controller {

		public function __construct() {
			parent::__construct();
		}
		
		public function index() {
			if(isset($this->urlParams['id'])) {
				$this->model = new Artist();
			}
			else { 
				$this->validId = false;
				$this->pageTitle = "Invalid profile";
			}
		}
	}
?>