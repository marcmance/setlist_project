<!-- START LEFT SIDE CONTAINER -->
<div class="profileMenu">
	<div>
		<table class="userProfileStats">
			<tr class="numberStatsTR">
				<td class="setlistCountTd">
					<b><?php echo "<a href='/user/" . $con->profileUser->username . "'>". count($con->setlists) . "</a>"; ?></b>
				</td>
				<td>
					<b><?php echo "<a href='/user/" . $con->profileUser->username . "/artists'>". $con->artistCount . "</a>"; ?></b>
				</td>
				<td>
					<b><?php echo $con->venueCount; ?></b>
				</td>
			</tr>
			<tr class="nameStatsTR">
				<td>
					<b>Setlists</b>
				</td>
				<td>
					<b>Artists</b>
				</td>
				<td>
					<b>Venues</b>
				</td>
			</tr>
		</table>
	</div>
	<br/>
	<div class="infoBox topArtist">
		<div class="infoBoxHeader">
			TOP ARTIST
		</div>
		<div class="infoBoxImage">
			<div class="infoNumberContainer">
				<div class="infoNumber">
					<?php //echo $con->topArtist['artist_count']; ?>
					<?php echo $con->topArtist['artist_name'] . "(". $con->topArtist['artist_count'] . ")"; ?>
				</div> 
			</div>
			<?php echo "<script>infoBox('topArtist','artists','".toLowerCaseAndTrim($con->topArtist['artist_name'])."')</script>"; ?>
		</div>

		<!--
		<div class="infoBoxFooter">
			<?php echo $con->topArtist['artist_name']; ?>
		</div>
	-->
	</div>
	<br/>
	<div class="infoBox topVenue">
		<div class="infoBoxHeader">
			TOP VENUE
		</div>
		<div class="infoBoxImage">
			<div class="infoNumberContainer">
				<div class="infoNumber">
					<?php //echo $con->topArtist['artist_count']; ?>
					<?php //echo $con->topVenue['venue_name']; ?>
					6
				</div> 
				<?php echo "<script>infoBox('topVenue','venues','".$con->topVenue['venue_name']."')</script>"; ?>
			</div>
		</div>
		<div class="infoBoxFooter">
			<?php echo $con->topVenue['venue_name']; ?>
		</div>
	</div>
</div> <!-- END LEFT SIDE CONTAINER -->