<?php	
	include 'controllers/yourSetlistsController.php';
?>

<html>
	<head>
		<link href="styles/viewSetlistStyles.css" type="text/css" rel="stylesheet" />
		<title>Your setlists </title>
		<script src="jquery-1.8.0.min.js"></script>
		<script src="helper_functions.js"></script>
	</head>
	
	<body>
		<?php include 'header.php'; ?>
		<?php include 'view_setlist_menu.php';?>
		
		
		<div class="setlistContainerListView">
			<div class="setlistDate">
				<span class="setlistMonth">APRIL</span><br/>
				<span class="setlistDay">20</span><br/>
				<span class="setlistYear">2013</span><br/>
			</div>
			<div class="setlistInfo">
				<span class="setlistArtist">Motion City Soundtrack</span><br/>
				<span class="setlistVenue">Starland Ballroom, Sayerville, NJ</span>
			</div>
			<div class="clearfix"></div>
		</div>
		<!--- OLD -->
		<?php if($set != null) { ?>
			<table cellspacing="20" cellpadding="0">	
				<tr>
					<td><b>Date</b></td>
					<td><b>Artist</b></td>
					<td><b>Venue</b></td>
					<td><b>Link</b></td>
				</tr>
				<?php while($row = $set->fetch_assoc()) {?>
					<tr>
						<td>
							<?php echo $row['date'];?>
						</td>
						<td>
							<?php echo $row['artist_name'];?>
						</td>
						<td>
							<?php echo $row['venue_name'] . ", " . $row['city'] . ", " . $row['state'];?>
						</td>
						<td>
							<?php echo '<a href="viewSetlist.php?setlist_id='.$row['setlist_id'].'">Go</a>';?>
						</td>
					</tr>
				<?php } ?>	
			</table>
		<?php
			}
			else {
				echo "No results";
			}
		?>
	</body>
</html>