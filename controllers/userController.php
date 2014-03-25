<?php
	class userController extends Controller {
	
		public $profileUser;
		public $setlists;
		public $artistCount;
		public $venueCount;

		public $topArtist;
		public $topVenue;

		public $userArtistList;
		
		public function __construct() {
			$this->artistCount = 0;
			$this->venueCount = 0;
			parent::__construct();
		}
		
		public function index() {
			if(isset($this->urlParams['id'])) {
				$this->profileUser = new User();
				if($this->profileUser->find($this->urlParams['id'],"username") != null) {
					$this->pageTitle = $this->profileUser->getFullName() . " | Profile";
					$this->validId = true;
					
					$s = new Setlist();
					$this->setlists = $s->where("user_id",intval($this->profileUser->user_id))
						->join("venue", array("venue_name", "city", "state"))
						->join("artist", array("artist_name"))
						->order("date", false)
						->findAll();

					$this->getTopArtist($s);
					$this->getTopVenues($s);

				}
				else { 
					 $this->validId = false;
					 $this->pageTitle = "Invalid profile";
				}
			}

			//$this->generateUrlPaths();
		}
		
		public function edit() {
			if($this->loggedIn) {
				$this->pageTitle = $this->s_user->getFullName() . " | Edit Profile";
			}
			else {
				$this->redirect("/login");
			}
		}
		
		public function register() {
			//add a redirect here
		}
		
		public function create() {
			if($this->ifPost()) {
				
			}
			else {
				$this->redirect("/login");
			}
		}

		public function artists() {

			if(isset($this->urlParams['id'])) {
				$this->profileUser = new User();
				if($this->profileUser->find($this->urlParams['id'],"username") != null) {
					$this->pageTitle = $this->profileUser->getFullName() . " | Artists" ;
					$this->validId = true;
					if(isset($this->urlParams['childId']) ) {
						//echoPretty($this->urlParams['childId']);
					}
					else {
						$s = new Setlist();

						//cache this result or change query for count 
						$this->setlists = $s->where("user_id",intval($this->profileUser->user_id))
						->join("venue", array("venue_name", "city", "state"))
						->join("artist", array("artist_name"))
						->order("date", false)
						->findAll();

						$this->userArtistList = $this->getTopArtist($s, true);
						$this->getTopVenues($s);
					}
				}
			}
		}


		/* HELPER FUNCTIONS */

		//$order
		//true = order by name
		//false = order by count
		private function getTopArtist($s, $order = false) {
			if(isset($this->profileUser)) {
				if($temp = $s->getAllSetlistArtists($this->profileUser->user_id, $order)) {
					$this->artistCount = $temp->num_rows;
					$this->topArtist = $temp->fetch_assoc();
				}

				mysqli_data_seek($temp, 0);
				return $temp;
			}
		}

		private function getTopVenues($s) {
			if(isset($this->profileUser)) {
				if($temp = $s->getAllSetlistVenues($this->profileUser->user_id)) {
					$this->venueCount = $temp->num_rows;
					$this->topVenue = $temp->fetch_assoc();
				}
			}
		}
	}

?>