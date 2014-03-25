<?php	
	include 'controllers/viewSetlistController.php';
?>
<html>
	<head>
		<link href="styles/viewSetlistStyles.css" type="text/css" rel="stylesheet" />
		<title><?php echo $set->artist_name . " @ " . $set->venue_name ?> </title>
		<script src="jquery-1.8.0.min.js"></script>
		<script src="helper_functions.js"></script>
		<script>	
			$(document).ready(function() {
				var selectedAlbumId = "";
				var selectedNewSongs = false;
				
				$("#totalSongs").click(function() {
					if(selectedNewSongs) {
						turnOffSelectedNewSongs();
					}
					if(selectedAlbumId != "") {
						turnOffSelectedAlbum();
					}
				});
				
				$("#newsongs").click(function() {
					if(selectedNewSongs) {
						turnOffSelectedNewSongs();
					}
					else {
						$("li").not(".newSong").css("opacity", 0.1);
						selectedNewSongs = true;
					}
				});
				
				$(".album").click(function() {
					if(selectedAlbumId != "") {
						turnOffSelectedAlbum();
					}
					selectedAlbumId = parseId($(this).attr("id"));
					$("li.a-"+selectedAlbumId).css("background", selectedColor);
				});
				
				function turnOffSelectedNewSongs() {
					$("li").not(".newSong").css("opacity", 1);
					selectedNewSongs = false;
				}
				
				function turnOffSelectedAlbum() {
					$("li.a-"+selectedAlbumId).each(function(){
						if($(this).hasClass("encore")) {
							$(this).css("background", encoreColor);
						}
						else{
							$(this).css("background", startColor);
						}
					});
					selectedAlbumId = "";
				}
			});
		</script>
	</head>
	
	<body>
		<?php include 'header.php'; ?>
	
		<span id="artist_header"><?php echo $set->artist_name ?></span><br/>
		<span id="date_header"><?php echo $set->setlist_date ?></span><br/>
		<span id="venue_header"><?php echo $set->venue_name . ", " . $set->venue_city . ", " .  $set->venue_state ?></span>
		<br/>
		
		<table cellspacing="0" cellpadding="0">
			<tr>
				<td id="setlistTd">
					<div>
						<ul>
							<?php
								$encoreStart = true;
								foreach($ss_array as $s) {
									if($s->encore == 1) {
										//add encore line
										if($encoreStart) {
											echo '<li class="encore_line"></li>';
											$encoreStart = false;
										}
										echo '<li class="encore a-'.$s->album_id;
									}
									else {
										echo '<li class="a-'.$s->album_id;
									}
									
									if(in_array($s->song_id, $ss_diff)) {
										echo ' newSong"><strong>'.$s->song_name."</strong>";
									}
									else{
										echo '">'.$s->song_name;
									}
									
									
									if($s->setlist_notes != "") {
										echo ' <span class="song_notes">('.$s->setlist_notes.")</span></li>"; 
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
									<div class="numbers"><?php echo count($ss_array);?></div>
								</div>
							</td>
							<td class="rightCol">
								Total songs
							</td>
						</tr>
						
						<tr>
							<td>
								<div id="newsongs" class="number_container">
									<div class="numbers"><?php echo count($ss_diff);?></div>
								</div>
							</td>
							<td class="rightCol">
								New songs viewed
							</td>
						</tr>
						
						<!-- ALBUM STATS -->
						<?php foreach($album_count as $key => $arr) { ?>
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
	</body>
</html>	
	