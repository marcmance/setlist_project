<?php

	require_once "model.php";
	class Artist extends Model {

		public function __construct() {
			$this->fields_array = array("artist_id", 
										"artist_name",
										"created_date",
										"updated_date");
			parent::__construct();							
		}
	}
	/*
	class Song extends Model {

		public function __construct() {
			$this->fields_array = array("song_id", 
										"song_name",
										"artist_id");
			parent::__construct();							
		}
	}	
	
	class Setlist_Song extends Model {

		public function __construct() {
			$this->fields_array = array("setlist_song_id", 
										"song_id",
										"artist_id");
			parent::__construct();							
		}
	}	
	*/

?>