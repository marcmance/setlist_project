<?php
	include 'connection.php';
	$choice = mysql_real_escape_string($_GET['choice']);
	$album_query = "Select * from album where artist ='$choice'";
	$album_result = mysql_query($album_query);
	$song_query = "Select * from song where artist ='$choice'";
	$song_result = mysql_query($song_query);
	
	$songArr[] = array();
	while ($row = mysql_fetch_array($song_result)) {
		$songArr[$row{'album'}][$row{'songId'}] = $row{'name'};
	}
	
	$counter = 1;
	echo "<table>";
	while ($row = mysql_fetch_array($album_result)) {
		if($counter%2 != 0) {
			echo "<tr><td valign=\"top\" width=\"300\">";
			echo "<b>" . $row{'name'} . " (". $row{'year'} .")</b><br/>";
			echo "<ul class=\"connected\">";
			foreach ($songArr[$row{'id'}] as $k => $s) {
				//echo "<input type=\"checkbox\" id=\"" .$k . "\"/> $s<br/>";
				echo "<li id=\"" .$k . "\"> <b>$s</b></li>";
			}
			echo "</ul>";
			echo "</td>";
		}
		else {
			echo "<td valign=\"top\">";
			echo "<b>" . $row{'name'} . " (". $row{'year'} .")</b><br/>";
			echo "<ul class=\"connected\">";
			foreach ($songArr[$row{'id'}] as $k => $s) {
				//echo "<input type=\"checkbox\" id=\"" .$k . "\"/> $s<br/>";
				echo "<li id=\"" .$k . "\"> <b>$s</b></li>";
			}
			echo "</ul>";
			echo "</td></tr>";
			echo "<tr><td height=\"10\"></td></tr>"; // buffer row
		}
		$counter++;
	}
	//close table if odd
	if($counter%2 != 0) {
		echo "<td></td></tr>";
	}
	echo "</table>";
	
	echo "<ul class=\"connected\" id=\"mainList\"><li>test</li></ul>";
	
	foreach ($songArr as $song) {
		foreach ($song as $s) {
			//echo "$s<br/>";
		}
	}
?>
<script>
$('.connected').sortable({
	connectWith: '#mainSetlist'
});

</script>