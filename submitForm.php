<?php
	//$songArray = $_POST['songs'];
	//$songsArr = json_decode($songsJSON);
	
	include 'connection2.php';
	$posted_data = array();
    if (!empty($_POST['hidden_input'])) {
        $posted_data = json_decode($_POST['hidden_input'], true);
    }
/*
	print_r($posted_data);
	echo '<br/>';
	echo '<br/>';
	echo '<br/><b>Date: </b>'. $_POST['date'];
	echo '<br/><b>Artist: </b>'. $_POST['artistSelect'];
	echo '<br/><b>Venue: </b>'. $_POST['venueSelect'];
	echo '<br/>';
	foreach ($posted_data as $s) {
		echo $s['id'] . '<br/>';
		echo $s['encore']. '<br/>';
		echo strip_tags($s['description']). '<br/>';
		echo '<br/>';
	}
	*/
	$insert_id = null;
	if($stmt = $mysqli->prepare("INSERT INTO setlist (artist_id,venue_id,date,created_date,updated_date,user_id) VALUES (?, ?, ?, now(), now(),1)")) {
		$stmt->bind_param("iis", $_POST['artistSelect'], $_POST['venueSelect'], $_POST['date']);
		$stmt->execute();
		$insert_id = $stmt->insert_id;
		$stmt->close();
		if($setlist_song_stmt = $mysqli->prepare("INSERT INTO setlist_song (setlist_id,song_id,notes,encore,setlist_order,opener,closer,album_id,created_date,updated_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, now(),now())")) {
			$setlist_order = 1;
			$opener = 1;
			$closer = 0;
			
			foreach ($posted_data as $s) {
				$e = 0;
				if($s['encore'] === "true") {
					$e = 1;
				}
				
				if($setlist_order != 1) {
					$opener = 0;
				}
				if($setlist_order == count($posted_data)) {
					$closer = 1;
				}
				$setlist_song_stmt->bind_param("iisiiiii", $insert_id, $s['id'], strip_tags($s['description']), $e, $setlist_order,$opener,$closer,$s['album_id']);
				$setlist_song_stmt->execute();
				echo $setlist_song_stmt->error;
				$setlist_order++;
				echo "sl song id = " . $setlist_song_stmt->insert_id . "<br/>";
			}
			$setlist_song_stmt->close();
		}
		else {
			echo("Statement failed: ". $mysqli->error. "<br>");
		}
	}
	else {
		echo("Statement failed: ". $mysqli->error. "<br>");
	}
	
	$mysqli->close();	
	

	//$insertQuery = "Insert into setlist (artist,venue,date) values ";
	//$insertQuery .= "(".$_POST['artistSelect'].",".$_POST['venueSelect'] .",".$_POST['date'].")";
	foreach ($posted_data as $s) {
		echo $s['id'] . '<br/>';
		echo $s['encore']. '<br/>';
		echo strip_tags($s['description']). '<br/>';
		echo '<br/>';
	}
	//echo $insertQuery;
	echo '<br/>';
	echo '<a href="newSetlist.php">back</a>';

	echo '<a href="/setlist/' . $setlist_song_stmt->insert_id . '">GO></a>';

	if($mysqli->error == "") {
		//header("Location: /setlist/" . $mysqli->insert_id);
		//die();
	}
?>