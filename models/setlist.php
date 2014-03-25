<?php

	class Setlist extends Model {

		public function __construct() {
			$this->fields_array = array("artist_id", 
										"date",
										"headline",
										"setlist_id",
										"venue_id",
										"created_date",
										"updated_date",
										"user_id");
			parent::__construct();							
		}
		
		public function getSetlistByArtist($artist_id) {
			$query = "SELECT setlist.setlist_id, setlist.date, artist.artist_name, venue.venue_name, venue.city, venue.state
					FROM setlist
					JOIN artist
					ON setlist.artist_id = artist.artist_id
					JOIN venue
					ON setlist.venue_id = venue.venue_id
					where setlist.artist_id = " . $artist_id;
			return $this->query($query);
		}

		//gets all setlists by a particular artist by user
		public function getAllSetlistArtists($user_id, $name = false) {
			$user_id = intval($user_id);
			$orderBy = "artist_count DESC";
			if($name) {
				$orderBy = "artist.artist_name";
			}

			$query = "SELECT COUNT(artist.artist_id) as artist_count, artist.artist_name, artist.artist_id
					FROM setlist
					JOIN artist
					ON artist.artist_id = setlist.artist_id
					GROUP BY artist.artist_name
					ORDER BY " . $orderBy;

			$result = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			$setlist_array = array();
			if($result->num_rows > 0) {
				return $result;
			}
			else {
				return false;	
			}
		}

		public function getAllSetlistVenues($user_id) {
			$user_id = intval($user_id);
			$query = "SELECT COUNT(venue.venue_id) as venue_count, venue.venue_id, venue.venue_name
					FROM setlist
					JOIN venue
					ON venue.venue_id = setlist.venue_id
					JOIN user
					ON user.user_id = setlist.user_id
					WHERE user.user_id = " . $user_id . " " .
					"GROUP BY venue.venue_name
					ORDER BY venue_count DESC";
			$result = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			$setlist_array = array();
			if($result->num_rows > 0) {
				//printArray($result);
				//echo $result->num_rows;
				return $result;
			}
			else {
				return false;	
			}
		}

	}

	class Setlist_db {
		public $mysqli;
		
		public function __construct($mysqli) {
			$this->mysqli = $mysqli;
		}
	
		public function getSetlist($id) {
			$query = "SELECT setlist.setlist_id, setlist.date, artist.artist_name, venue.venue_name, venue.city, venue.state
					FROM setlist
					JOIN artist
					ON setlist.artist_id = artist.artist_id
					JOIN venue
					ON setlist.venue_id = venue.venue_id
					where setlist.setlist_id = ?";
	
			if ($stmt = $this->mysqli->prepare($query)) {
				$stmt->bind_param('i', $id);
				$stmt->execute();
				$stmt->bind_result($setlist_id,$setlist_date,$artist_name,$venue_name,$venue_city,$venue_state);
				$stmt->fetch();

				$set = new Setlist2();
				$set->setlist_id = $setlist_id;
				$set->setlist_date = $setlist_date;
				$set->artist_name = $artist_name;
				$set->venue_name = $venue_name;
				$set->venue_city = $venue_city;
				$set->venue_state = $venue_state;
				
				$stmt->close();
				return $set;
			}
		}
		
		//modify down the line to accept user id
		public function getAllSetlists() {
			$query = "SELECT setlist.setlist_id, setlist.date, artist.artist_name as artist_name, venue.venue_name as venue_name, venue.city, venue.state
					FROM setlist
					JOIN artist
					ON setlist.artist_id = artist.artist_id
					JOIN venue
					ON setlist.venue_id = venue.venue_id
					ORDER by setlist.date DESC";
					//WHERE user.id = ?";
			$result = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			
			$setlist_array = array();
			if($result->num_rows > 0) {
				return $result;
			}
			else {
				return null;	
			}
		}
		
		
		//modify down the line to accept user id
		//gets all setlists
		public function getAllSetlistArtists() {
			
			$query = "SELECT DISTINCT(artist.artist_name) as artist_name, artist.artist_id as artist_id
					FROM setlist
					JOIN artist
					ON artist.artist_id = setlist.artist_id
					ORDER BY artist.artist_name";

			$result = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			
			if($result->num_rows > 0) {
				return $result;
			}
			else {
				return null;	
			}
		}
		
		//gets all setlists for a particular artist
		public function getSetlistByArtist($artist_id) {
			$query = "SELECT setlist.setlist_id as setlist_id, setlist.date as date, artist.artist_name as artist_name, venue.venue_name as venue_name, venue.city, venue.state
					FROM setlist
					JOIN artist
					ON setlist.artist_id = artist.artist_id
					JOIN venue
					ON setlist.venue_id = venue.venue_id
					where setlist.artist_id = " . $artist_id;
					//AND user id = ?
			$result = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			$setlist_array = array();
			if($result->num_rows > 0) {
				return $result;
			}
			else {
				return null;	
			}
		}
	}
	
	class Setlist2 {
		public $setlist_id;
		public $setlist_date;
		public $artist_name;
		public $venue_name;
		public $venue_city;
		public $venue_state;	
	}

?>