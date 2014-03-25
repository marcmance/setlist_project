<?php
	include 'connection.php';
	$choice = mysql_real_escape_string($_GET['choice']);
	$album_query = "Select * from album where artist ='$choice'";
	$album_result = mysql_query($album_query);
	
	while ($row = mysql_fetch_array($album_result)) {
		echo "<option value=\"".$row{'id'} . "\">".$row{'name'} . "</option>";
	}

?>
<script>
$('.connected').sortable({
	connectWith: '#mainSetlist'
});

</script>