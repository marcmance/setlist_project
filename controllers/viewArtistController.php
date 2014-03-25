<?php	
	include '/connection2.php';
	require_once 'models/model.php';
	include 'models/setlist.php';
	include 'models/artist.php';
	include 'models/setlist_song.php';

	$artist_id = $_GET['id'];

	$setlist = new Setlist();
	$artist_setlists = $setlist->where("artist_id",intval($artist_id))
				->join("venue", array("venue_name", "city", "state"))
				->join("artist", array("artist_name"))
				->findAll();
	$artist_setlist_count = count($artist_setlists);	

	$artist = new Artist();
	$artist->find($artist_id);
	
	$ssdb = new Setlist_Song_db($mysqli);
	$song_counts_array = $ssdb->getSongCounts($artist_id);
	
	$mysqli->close();	
	
	
?>
