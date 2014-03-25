<?php
include 'connection.php';
?>

<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
		<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>-->
		<script src="jquery-1.8.0.min.js"></script>
		
		<script>
		$(document).ready(function() {
			var counter = 0;
			$("#testButton").click(function() {
				var newRow = $("<tr><td>hi"+counter +"</td><td>hi"+counter+"</td></tr>");
				$("#testTable").append(newRow);
				counter++;
				$("#testDiv").load("test.txt");
			});
			
			$("#artistSelect").change(function() {
				$("#albumSelect").load("getAlbums2.php?choice=" + $("#artistSelect").val());
			});
			
			$("form").submit(function() {
				//alert($("#songTextArea").val());
			});
		});
		</script>
		<title>Test Page</title>
		<style>
			table, td {
				border: 1px solid black;
			}
			
			#artistSelect {
				border-radius: 10px;
				font-size: 20px;
				font-family: Verdana;
				color: #4bb8d3;
				overflow:hidden;
			}
		</style>
	</head>
	<body>
		<form action="insertSong.php" method="post">
		<select id="artistSelect" name="artistSelect">
			<option>Please select an artist</option>
			<?php 
				$query = "Select * from artist";
				$result = mysql_query($query);
				while ($row = mysql_fetch_array($result)) {
					echo "<option value=\"".$row{'id'} . "\">".$row{'name'} . "</option>";
				}
			?>
		</select>
		<br/><br/>
		<select id="albumSelect" name="albumSelect">
			<option>Please choose from above</option>
		</select>
		<br/>
		<!--<input type="text" style="width:200px;height:300px;vertical-align:top">-->
		<textarea cols="20" rows="25" wrap="hard" id="songTextArea" name="songTextArea"></textarea>
		<br/>
		<input type="submit" value="enter" align="top">
		</form>
		

	</body>
</html>