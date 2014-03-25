<?php
include 'connection.php';

//echo "" . $_POST['songTextArea'] . "<br/>";

$songText = $_POST['songTextArea'];
$albumId = $_POST['albumSelect'];
$artistId = $_POST['artistSelect'];

echo "album id = ".$albumId;
echo "artist id = ".$artistId;

$songTextPieces = explode("\n", $songText);
$count = count($songTextPieces);
$insertQuery = "Insert into song (name,artist,album,tracking,bonus) values ";

for($i=0; $i < $count; $i++) {
	
	$tracking = $i + 1;
	$insertQuery .= "('". trim($songTextPieces[$i]) . "',". $artistId .", ". $albumId. ", ". $tracking .",". 0 .")";
	if ($i < ($count - 1)) {
		$insertQuery .= ", ";
	}
}
mysql_query($insertQuery);
echo "<br/><br/>";
echo $insertQuery;
echo "<br/><br/><a href=\"artist_songs.php\">RETURN</a>";


/*

INSERT INTO testTable (name) VALUES ();

*/






/*
foreach ($songTextPieces as $v) {
	$insertQuery = $insertQuery . "(" . $v . "),";
} */

$insertQuery = $insertQuery


?>

