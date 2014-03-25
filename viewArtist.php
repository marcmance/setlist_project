<?php	
	include 'controllers/viewArtistController.php';
?>

<html>
	<head>
		<link href="styles/viewSetlistStyles.css" type="text/css" rel="stylesheet" />
		<title><?php echo $artist->artist_name; ?> stats </title>
		<script src="jquery-1.8.0.min.js"></script>
		<script src="helper_functions.js"></script>
	</head>
	
	<body>
		<span id="artist_header"><?php echo $artist->artist_name; ?></span>
		<br/>
		<div id="totalSongs" class="number_container">
			<div class="numbers"><?php echo $artist_setlist_count;?></div> Number of times
		</div>

		<br/>
		<hr/>
		<b>Song Stats</b></br>
		</br>
		<?php if($song_counts_array != null) { ?>
			<table>
			<!--
				<tr>
					<td>Count</td>
					<td>Song</td>
				</tr>-->
				<?php foreach($song_counts_array as $s) { ?>
					<tr>
						<td>
							<div class="number_container_small">
								<div class="numbers_small"><?php echo $s->song_count;?></div>
							</div>
						</td>
						<td><?php echo $s->song_name;?></td>
					</tr>
				<?php } ?>
			</table>	
		<?php }?>
		<hr/>
		List of setlists<br/>
		<br/>
		<?php if($artist_setlists != null) { ?>
			<table cellspacing="20" cellpadding="0">	
				<tr>
					<td><b>Date</b></td>
					<td><b>Artist</b></td>
					<td><b>Venue</b></td>
					<td><b>Link</b></td>
				</tr>
				<?php foreach($artist_setlists as $sets) {?>
					<tr>
						<td>
							<?php echo $sets['date'];?>
						</td>
						<td>
							<?php echo $sets['artist_name'];?>
						</td>
						<td>
							<?php echo $sets['venue_name'] . ", " . $sets['city'] . ", " . $sets['state'];?>
						</td>
						<td>
							<?php echo '<a href="viewSetlist.php?setlist_id='.$sets['setlist_id'].'">Go</a>';?>
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