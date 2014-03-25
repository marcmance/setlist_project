<?php
include 'connection2.php';

$row = 1;
$query = "SELECT * FROM artist";
$result = $mysqli->query($query) or die($mysqli->error.__LINE__);
$artist_array = array();
if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		if(!array_key_exists($row['artist_name'], $artist_array)) {
			$artist_array[$row['artist_name']] = $row['artist_id'];
		}
	}
}
print_array($artist_array);

$album_insert_stmt = $mysqli->prepare("INSERT INTO album (artist_id,album_name,year,cover_art_url, created_date,updated_date) VALUES (?, ?, ?, ?, now(),now())");
$song_insert_stmt = $mysqli->prepare("INSERT INTO song (song_name,artist_id,album_id,tracking,bonus,created_date,updated_date) values (?,?,?,?,?,now(),now())");

$insert_id = "";
if($_GET['p'] == "true") {
	if (($handle = fopen("test_csv4.csv", "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$num = count($data);
			for ($c=0; $c < $num; $c++) {
				if($data[$c] == "ALBUM") {
					echo "<b>".$data[$c+4] . "</b><br />\n";
					$artist_id = $artist_array[$data[$c+1]];
					$album_insert_stmt->bind_param("isss", $artist_id, $data[$c+2], $data[$c+3], $data[$c+4]);
					$album_insert_stmt->execute();
					$insert_id = $album_insert_stmt->insert_id;
					break;
				}
				else {
					$bonus = 0;
					if($data[$c+2] != "") {
						$bonus = 1;
					}
					$song_insert_stmt->bind_param("siiii", $data[$c+1], $artist_id, $insert_id, $data[$c], $bonus);
					$song_insert_stmt->execute();
					break;
				}
			}
		}
		$album_insert_stmt->close();
		$song_insert_stmt->close();
		$mysqli->close();
		fclose($handle);
	}
}

?>