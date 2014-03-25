<div id="page-setlist-index" class="gen-page-container">
	<a href="/user/<?php echo $con->set->user_id; ?>"><< back to <?php echo $con->set->user_first_name;?></a><br/>
	<br/>
	<span class="setlistArtist"><?php echo $con->set->artist_name; ?></span><br/>
	<span id="date_header"><?php echo formatDate($con->set->date); ?></span><br/>
	<span class="setlistVenue"><?php echo $con->set->venue_name . ", " . $con->set->city . ", " .  $con->set->state; ?></span>
	<br/>

	<br/>
	<div class="userSetlistStats">
		This is your <b><?php echo $con->artist_times; ?></b> time seeing <?php echo $con->set->artist_name ?>.
		<?php if($con->artist_times > 1) { ?>
			Last time viewed: <a href="/setlist/<?php echo $con->lastSetlistId; ?>"> <?php echo formatDate($con->lastSetlistDate) . " @ " . $con->lastSetlistVenueName; ?>  </a>
		<?php } ?>

		<br/><br/>

		This is your <b><?php echo $con->venue_times; ?></b> time at <?php echo $con->set->venue_name ?>.
		<?php if($con->venue_times > 1) { ?>
			Last time here: <a href="/setlist/<?php echo $con->lastVenueSetlistId; ?>"> <?php echo $con->lastVenueArtistName ." - " . formatDate($con->lastVenueSetlistDate) ?>  </a>
		<?php } ?>

		<br/>
	</div>
	
	<br/>

	<table cellspacing="0" cellpadding="0">
		<tr>
			<td id="setlistTd">
				<div>
					<ul>
						<?php
							$encoreStart = true;
							foreach($con->setlist_songs as $s) {
								if($s['encore'] == 1) {
									//add encore line
									if($encoreStart) {
										echo '<li class="encore_line"></li>';
										$encoreStart = false;
									}
									echo '<li class="encore a-'.$s['album_id'];
								}
								else {
									echo '<li class="a-'.$s['album_id'];
								}
								
								if(in_array($s['song_id'], $con->ss_diff)) {
									echo ' newSong"><strong>'.$s['song_name']."</strong>";
								}
								else{
									echo '">'.$s['song_name'];
								}
								
								
								if($s['notes'] != "") {
									echo ' <span class="song_notes">('.$s['notes'].")</span></li>"; 
								}
								else {
									echo "</li>";
								}
							}
						?>
					</ul>
				</div>
			</td>	
			<td id="statsTd">
				<b>By the numbers:</b><br/>
				<br/>
				<table id="statsTable" cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td>
							<div id="totalSongs" class="number_container">
								<div class="numbers"><?php echo count($con->setlist_songs);?></div>
							</div>
						</td>
						<td class="rightCol">
							Total songs
						</td>
					</tr>
					
					<tr>
						<td>
							<div id="newsongs" class="number_container">
								<div class="numbers"><?php echo count($con->ss_diff);?></div>
							</div>
						</td>
						<td class="rightCol">
							New songs viewed
						</td>
					</tr>
					
					<!-- ALBUM STATS -->
					<?php foreach($con->songs_on_albums as $key => $arr) { ?>
					<tr>
						<td>
							<div id="al-<?php echo $key ?>" class="number_container album" style="background-image: url(/imgs/<?php echo $arr["url"]?>); background-size:90px 90px">
								<div class="numbers_album"><?php echo $arr["count"];?></div>
							</div>
						</td>
						<td class="rightCol">
							<?php echo $arr["name"] ?>
						</td>
					</tr>
					<?php } ?>
				</table>
			</td>
		</tr>	
	</table>
</div>