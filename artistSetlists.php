<?php	
	include 'controllers/artistSetlistsController.php';
?>

<html>
	<head>
		<link href="styles/viewSetlistStyles.css" type="text/css" rel="stylesheet" />
		<title>Artist Setlists </title>
		<script src="jquery-1.8.0.min.js"></script>
		<script src="helper_functions.js"></script>
	</head>
	
	<body>
		<?php include 'header.php'; ?>
		<?php include 'view_setlist_menu.php';?>
		
		<div id="artist_setlists">
		<?php while($row = $set->fetch_assoc()) {?>
			<?php echo '<a href="viewArtist.php?id='.$row['artist_id'].'">'. $row['artist_name'] . '</a><br/>';?>				
		<?php } ?>	
		</div>
	</body>
</html>