<?php
	include 'connection2.php';
	
	//$query = "SELECT * FROM album where artist = 1";
	//$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

	$artist = 1;

	/* create a prepared statement */
	if ($stmt = $mysqli->prepare("SELECT album.id,album.name as album_name, artist.name as artist_name FROM album JOIN artist ON artist.id=album.artist WHERE artist=?")) {

		/* bind parameters for markers */
		$stmt->bind_param('i', $artist);
		$stmt->execute();
		$stmt->bind_result($id, $names, $namess);
		/* fetch value */
		while($stmt->fetch()) {
			//printf("%i is in district %i <br/>", $artist, $id);
			echo $id;
			//printf("%s\n", $col1, $col2);
		}

		
		/* get resultset for metadata */
		$result = $stmt->result_metadata();

		/* retrieve field information from metadata result set */
		while(	$field = $result->fetch_field()) {
			echo $field->name;
		}
		/* close statement */
		$stmt->close();
	}

	/* close connection */
	$mysqli->close();	
	
	/*
	
	$statement = $mysqli->prepare("SELECT * FROM album where artist = ?");
	$statement->bind_param('i', $artist);
	$statement->execute(); */
	
	
// GOING THROUGH THE DATA
/*
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo stripslashes($row['id']) . "<br/>";	
			echo stripslashes($row['name']) . "<br/>";
		}
	}
	else {
		echo 'NO RESULTS';	
	}
 */
?>