<?php

	class Setlist_Song extends Model {
		public function __construct() {
			$this->fields_array = array("setlist_song_id", 
										"song_id",
										"album_id",
										"closer",
										"opener",
										"encore",
										"notes",
										"setlist_id",
										"setlist_order",
										"created_date",
										"updated_date");
			parent::__construct();							
		}
	
		//Takes setlist and counts the number of songs per album
		public function getSongsOnAlbumCount($setlist_songs) {
			$songs_on_albums_array = array();
			foreach($setlist_songs as $ss) {
				if(!array_key_exists($ss['album_id'], $songs_on_albums_array)) {
					$songs_on_albums_array[$ss['album_id']]["url"] = $ss['cover_art_url'];
					$songs_on_albums_array[$ss['album_id']]["name"] = $ss['album_name'];
					$songs_on_albums_array[$ss['album_id']]["count"] = 1;
				}
				else {
					$songs_on_albums_array[$ss['album_id']]["count"]++;
				}
			}
			return $songs_on_albums_array;
		}

		//returns an array of all the song ids
		public function getSongIds($setlist_songs) {
			$song_ids = array();
			foreach($setlist_songs as $ss) {
				$song_ids[] = $ss['song_id'];
			}
			return $song_ids;
		}

		public function getFirstTimeSetlistSongs($song_id_array, $setlist_id, $setlist_date) {		
			
			$song_id_comma = implode(",", $song_id_array);
			
			//query to get all SETLIST SONGS in the set of all the IDS of this particular Setlist
			$query = "SELECT setlist.setlist_id, setlist_song.song_id, setlist.date, song.song_name 
							FROM setlist_song
							JOIN setlist
							ON setlist.setlist_id = setlist_song.setlist_id
							JOIN song
							ON song.song_id = setlist_song.song_id
							WHERE setlist.setlist_id != ? AND setlist.date < ? AND song.song_id in (".$song_id_comma.")";
			
			//echo "<br/>".$query;

			$song_seen_id_array = array();
			
			if($stmt = $this->mysqli->prepare($query)) {
				$stmt->bind_param('is', $setlist_id, $setlist_date);
				$stmt->execute();
				$stmt->bind_result($f_setlist_id, $f_song_id, $f_date, $f_name);
				while($stmt->fetch()) {
					$song_seen_id_array[] = $f_song_id;
				}
			}
			else {
				echo("<b>Statement failed: ". $this->mysqli->error. "</b><br/>");
			}

			$stmt->close();
			
			//comapre the the IDS to this setlist, as opposed to all of the user's setlist song
			$song_id_diff = array_diff($song_id_array, $song_seen_id_array);
			return $song_id_diff;
		}

	}


	class Setlist_Song_db {
		public $mysqli;
		public $song_id_array;
		public $songs_on_albums_array;
		
		public function __construct($mysqli) {
			$this->mysqli = $mysqli;
			$this->song_id_array = array();
			$this->songs_on_albums_array = array();
		}
		
		public function getSetlistSongs($setlist_id) {
			$setlist_song_query = "SELECT setlist_song.setlist_song_id, album.album_id,album.album_name,album.cover_art_url, song.song_id, song.song_name, 
				setlist_song.encore, setlist_song.notes, setlist_song.setlist_order,
				setlist_song.notes
				FROM setlist_song
				JOIN song
				ON setlist_song.song_id = song.song_id
				JOIN album
				ON song.album_id = album.album_id
				WHERE setlist_id = ?
				ORDER by setlist_order";
			
			$song_id_array = array();
			$setlist_song_array = array();
			if ($song_stmt = $this->mysqli->prepare($setlist_song_query)) {
				$song_stmt->bind_param('i', $setlist_id);
				$song_stmt->execute();
				$song_stmt->bind_result($setlist_song_id,$album_id,$album_name,$album_cover_art_url,$song_id,$song_name,$encore,$notes,$setlist_order,$setlist_notes);

				while($song_stmt->fetch()) {
					$ss = new SetlistSong();
					$ss->setlist_song_id = $setlist_song_id;
					$ss->song_id = $song_id;
					$ss->song_name = $song_name;
					$ss->encore = $encore;
					$ss->notes = $notes;
					$ss->setlist_order = $setlist_order;
					$ss->album_id = $album_id;
					$ss->album_name = $album_name;
					$ss->album_cover_art_url = $album_cover_art_url;
					$ss->setlist_notes = $setlist_notes;
					$setlist_song_array[] = $ss;
					
					//extra stuff
					$this->song_id_array[] = $song_id;
					if(!array_key_exists($ss->album_id, $this->songs_on_albums_array)) {
						$this->songs_on_albums_array[$ss->album_id]["url"] = $album_cover_art_url;
						$this->songs_on_albums_array[$ss->album_id]["name"] = $album_name;
						$this->songs_on_albums_array[$ss->album_id]["count"] = 1;
					}
					else {
						$this->songs_on_albums_array[$ss->album_id]["count"]++;
					}
				}
				$song_stmt->close();
				
				//print_r($this->songs_on_albums_array);
				
				return $setlist_song_array;
			}
		}
		
		//ONLY CALL IF $song_id_array IS POPULATED;
		//Returns a set of song_ids
		public function getFirstTimeSetlistSongs($setlist_id, $setlist_date) {		
			$song_id_comma = implode(",", $this->song_id_array);
			
			$song_first_time_query = "SELECT setlist.setlist_id, setlist_song.song_id, setlist.date, song.song_name 
							FROM setlist_song
							JOIN setlist
							ON setlist.setlist_id = setlist_song.setlist_id
							JOIN song
							ON song.song_id = setlist_song.song_id
							WHERE setlist.setlist_id != ? AND setlist.date < ? AND song.song_id in (".$song_id_comma.")";
			
			$song_seen_id_array = array();
			
			if($song_first_time_stmt = $this->mysqli->prepare($song_first_time_query)) {
				$song_first_time_stmt->bind_param('is', $setlist_id, $setlist_date);
				$song_first_time_stmt->execute();
				$song_first_time_stmt->bind_result($f_setlist_id, $f_song_id, $f_date, $f_name);
				while($song_first_time_stmt->fetch()) {
					$song_seen_id_array[] = $f_song_id;
				}
			}
			else {
				echo("<b>Statement failed: ". $mysqli->error. "</b><br/>");
			}
			$song_first_time_stmt->close();
			
			$song_id_diff = array_diff($this->song_id_array, $song_seen_id_array);
			return $song_id_diff;
		}
		
		public function getSongCounts($artist_id) {
			$setlist_song_query = "SELECT count(song.song_name) as song_count, song.song_name
									FROM setlist_song
									JOIN song
									ON song.song_id = setlist_song.song_id
									JOIN setlist
									ON setlist.setlist_id = setlist_song.setlist_id
									WHERE setlist.artist_id = ?
									GROUP BY song.song_name
									ORDER BY song_count desc";
			
			$song_id_array = array();
			$setlist_song_array = array();
			if ($song_stmt = $this->mysqli->prepare($setlist_song_query)) {
				$song_stmt->bind_param('i', $artist_id);
				$song_stmt->execute();
				$song_stmt->bind_result($song_count, $song_name);

				while($song_stmt->fetch()) {
					$ss = new SetlistSong();
					$ss->song_count = $song_count;
					$ss->song_name = $song_name;
					$setlist_song_array[] = $ss;
				}
				$song_stmt->close();
				
				return $setlist_song_array;
			}
		}
	}
	
	class SetlistSong {
		public $setlist_song_id;
		public $song_id;
		public $song_name;
		public $encore;
		public $notes;
		public $setlist_order;	
		public $album_id;
		public $album_name;
		public $album_cover_art_url;
		public $setlist_notes;
		public $song_count;
	}

?>