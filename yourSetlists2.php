<?php	
	include 'controllers/yourSetlistsController.php';
?>

<html>
	<head>
		<link href="styles/viewSetlistStyles.css" type="text/css" rel="stylesheet" />
		<link href="css/main.css" type="text/css" rel="stylesheet" />
		
		<title>Your setlists </title>
		<script src="jquery-1.8.0.min.js"></script>
		<script src="helper_functions.js"></script>
	</head>
	
	<body>
		<?php include 'header.php'; ?>
		<?php include 'view_setlist_menu.php';?>
		<?php include 'library/shared.php';?>
		
		<?php 
		while($row = $set->fetch_assoc()) {
		$dateExploded = dateParser($row['date']);
		?>
					
		<div class="setlistContainerListView">
			<div class="setlistDate">
				<span class="setlistMonth"><?php echo $dateExploded[1];?></span><br/>
				<span class="setlistDay"><?php echo $dateExploded[2];?></span><br/>
				<span class="setlistYear"><?php echo $dateExploded[0];?></span><br/>
			</div>
			<div class="setlistInfo">
				<span class="setlistArtist"><?php echo $row['artist_name'];?></span><br/>
				<span class="setlistVenue"><?php echo $row['venue_name'] . ", " . $row['city'] . ", " . $row['state'];?></span>
			</div>
			<div class="clearfix"></div>
		</div>
		
		<?php } ?>
	</body>
</html>