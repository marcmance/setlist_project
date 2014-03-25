<?php
	$username = "root";
	$password = "ichigo12";
	$hostname = "localhost";
	
	$dbhandle = mysql_connect($hostname, $username, $password) or die("Unable to connect to MySQL");
	$selected = mysql_select_db("setlist_db", $dbhandle) or die("Could not select examples");
	//$choice = mysql_real_escape_string($_GET['choice']);
	
	$query = "Select * from artist";
	
	
	$result = mysql_query($query);
	$counter = 1;
	while ($row = mysql_fetch_array($result)) {
   		echo $counter .". ". $row{'name'} . "<br/>";
		$counter++;
	}
	
	echo "<br/><br/>";
	
	$album_query = "Select * from album";
	$result2 = mysql_query($album_query);
	$counter = 1;
	while ($row = mysql_fetch_array($result2)) {
   		echo $counter .". ". $row{'name'} . "<br/>";
		$counter++;
	}

	
	$album_query = "Select * from song";
	$result2 = mysql_query($album_query);
	$counter = 1;
	while ($row = mysql_fetch_array($result2)) {
   		echo $counter .". ". $row{'name'} . "<br/>";
		$counter++;
	}
?>