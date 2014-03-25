<?php
	class setlistController extends Controller {
	
		public $set;
		public $setlist_songs;
		public $songs_on_albums;
		public $ss_diff;

		//setlist stat variables
		public $artist_times;
		public $lastSetlistDate;
		public $lastSetlistId;
		public $lastSetlistVenueName;

		public $venue_times;
		public $lastVenueSetlistDate;
		public $lastVenueSetlistId;
		public $lastVenueArtistName;

		public function __construct() {
			parent::__construct();
		}
		
		public function index() {
			if(isset($this->urlParams['id'])) {
				$this->set = new Setlist();

				if($this->set
					->join("venue", array("venue_name", "city", "state"))
					->join("artist", array("artist_name"))
					->join("user", array("user_first_name", "user_last_name","user_id"))
					->find(intval($this->urlParams['id'])) != null) {
					$this->validId = true;

					$this->pageTitle = $this->set->artist_name . " @ " . $this->set->venue_name;

					$ss = new Setlist_Song();
					$this->setlist_songs = $ss->join("song", array("song_id","song_name"))
						->join("album",array("album_id","album_name","cover_art_url"))
						->where("setlist_id",intval($this->urlParams['id']))
						->order("setlist_order", true)
						->findAll();

					$song_ids = $ss->getSongIds($this->setlist_songs);
					$this->songs_on_albums = $ss->getSongsOnAlbumCount($this->setlist_songs);

					$this->ss_diff = $ss->getFirstTimeSetlistSongs($song_ids,$this->urlParams['id'],$this->set->date);
						
					//EDIT MODEL FOR COUNT
					$sl = new Setlist();
					$artist_setlists = $sl->where("artist_id",intval($this->set->artist_id))
											->where("date",$this->set->date,"<")
											->join("venue", array("venue_name"))
											->order("date",false)
											->findAll();

					if($artist_setlists != null) {
						if(isSingleRecord($artist_setlists)) {
							$this->artist_times = getOrdinal(2);
							$this->lastSetlistId = $artist_setlists["setlist_id"];
							$this->lastSetlistDate = $artist_setlists["date"];
							$this->lastSetlistVenueName = $artist_setlists["venue_name"];
						}
						else {
							$this->artist_times = getOrdinal(count($artist_setlists) + 1);
							$this->lastSetlistId = $artist_setlists[0]["setlist_id"];
							$this->lastSetlistDate = $artist_setlists[0]["date"];
							$this->lastSetlistVenueName = $artist_setlists[0]["venue_name"];
						}
					}
					else {
						$this->artist_times = getOrdinal(1);
					}

					//$venue_setlists	
					
					$venue_setlists = $sl->where("venue_id",intval($this->set->venue_id))
											->where("date",$this->set->date,"<")
											->join("venue",array("venue_name"))
											->join("artist",array("artist_name"))
											->order("date",false)
											->findAll();				
					//printArray($venue_setlists);

					//TO DO. Bamboozle and multiple date
					if($venue_setlists != null) {
						if(isSingleRecord($venue_setlists)) {
							$this->venue_times = getOrdinal(2);
							$this->lastVenueSetlistId = $venue_setlists["setlist_id"];
							$this->lastVenueSetlistDate = $venue_setlists["date"];
							$this->lastVenueArtistName = $venue_setlists["artist_name"];
						}
						else {
							$this->venue_times = getOrdinal(count($venue_setlists) + 1);
							$this->lastVenueSetlistId = $venue_setlists[0]["setlist_id"];
							$this->lastVenueSetlistDate = $venue_setlists[0]["date"];
							$this->lastVenueArtistName = $venue_setlists[0]["artist_name"];
						}
					}
					else {
						$this->venue_times = getOrdinal(1);
					}
				}
				else {
					$this->validId = false;
				}
			}
		}
	}

?>