<?php	
	include 'connection2.php';
	require_once 'models/model.php';
	include 'models/setlist.php';
	include 'models/setlist_song.php';
	
	//Setlist_db->setConn($mysqli);
	$sid = $_GET['setlist_id'];
	$sdb = new Setlist_db($mysqli);
	$set = $sdb->getSetlist($sid);
	
	$setlist = new Setlist();
	$set2 = $setlist->join("venue", array("venue_name", "city", "state"))
					->join("artist", array("artist_name"))
					->find(intval($sid));
	//print_array($set2);				
	
	
	$ssdb = new Setlist_Song_db($mysqli);
	$ss_array = $ssdb->getSetlistSongs($sid);
	$ss_diff = $ssdb->getFirstTimeSetlistSongs($sid, $set->setlist_date);
	
	$album_count = $ssdb->songs_on_albums_array;
	
	
	$mysqli->close();	
	
?>
