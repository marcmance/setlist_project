<?php	
	include 'connection2.php';
	require_once 'models/model.php';
	include 'models/setlist.php';

	$sdb = new Setlist_db($mysqli);
	$set = $sdb->getAllSetlistArtists();
	
	$mysqli->close();	
	
?>
